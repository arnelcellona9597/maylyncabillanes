<?php
declare(strict_types=1);

/** Minimal SMTP client: STARTTLS on 587 + AUTH LOGIN. */
final class Mailer
{
    /** @var resource|null */
    private $sock = null;

    public function __construct(
        private string $host,
        private int $port,
        private string $user,
        private string $pass,
    ) {}

    /** @param string[] $to */
    public function send(string $from, string $fromName, array $to, string $replyTo, string $replyName, string $subject, string $body): void
    {
        $this->sock = stream_socket_client("tcp://{$this->host}:{$this->port}", $errno, $err, 15);
        if (!$this->sock) {
            throw new RuntimeException("SMTP connect failed: $err");
        }
        stream_set_timeout($this->sock, 15);

        $this->expect(220);
        $this->cmd('EHLO maylyncabillanes.com', 250);
        $this->cmd('STARTTLS', 220);
        if (!stream_socket_enable_crypto($this->sock, true, STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT)) {
            throw new RuntimeException('TLS negotiation failed');
        }
        $this->cmd('EHLO maylyncabillanes.com', 250);
        $this->cmd('AUTH LOGIN', 334);
        $this->cmd(base64_encode($this->user), 334);
        $this->cmd(base64_encode($this->pass), 235);
        $this->cmd("MAIL FROM:<$from>", 250);
        foreach ($to as $rcpt) {
            $this->cmd("RCPT TO:<$rcpt>", 250);
        }
        $this->cmd('DATA', 354);

        $headers = [
            'Date: ' . date('r'),
            'From: ' . $this->encodeName($fromName) . " <$from>",
            'To: ' . implode(', ', $to),
            'Reply-To: ' . $this->encodeName($replyName) . " <$replyTo>",
            'Subject: =?UTF-8?B?' . base64_encode($subject) . '?=',
            'Message-ID: <' . bin2hex(random_bytes(12)) . '@maylyncabillanes.com>',
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'Content-Transfer-Encoding: base64',
        ];
        $data = implode("\r\n", $headers) . "\r\n\r\n" . chunk_split(base64_encode($body), 76, "\r\n");
        fwrite($this->sock, $data . "\r\n.\r\n");
        $this->expect(250);
        $this->cmd('QUIT', 221);
        fclose($this->sock);
    }

    private function encodeName(string $name): string
    {
        return '=?UTF-8?B?' . base64_encode($name) . '?=';
    }

    private function cmd(string $line, int $code): void
    {
        fwrite($this->sock, $line . "\r\n");
        $this->expect($code);
    }

    private function expect(int $code): void
    {
        $resp = '';
        while (($l = fgets($this->sock, 515)) !== false) {
            $resp .= $l;
            if (strlen($l) < 4 || $l[3] === ' ') {
                break;
            }
        }
        if ((int)substr($resp, 0, 3) !== $code) {
            throw new RuntimeException('SMTP error: ' . trim($resp));
        }
    }
}
