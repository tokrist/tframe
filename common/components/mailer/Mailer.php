<?php

namespace tframe\common\components\mailer;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use tframe\common\helpers\CoreHelper;
use tframe\core\Application;
use tframe\core\exception\InvalidArgumentException;

class Mailer {
    public PHPMailer $mail;
    public string $SYSTEM_ADDRESS;

    public function __construct(array $config = []) {
        $this->mail = new PHPMailer();

        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->Host = $config['host'] ?? '';
        $this->mail->Username = $config['username'] ?? '';
        $this->mail->Password = $config['password'] ?? '';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = 465;
        $this->mail->CharSet = PHPMailer::CHARSET_UTF8;

        $this->SYSTEM_ADDRESS = $config['system_address'];

        $this->mail->From = $this->SYSTEM_ADDRESS;
        $this->mail->FromName = Application::$GLOBALS['APP_NAME'];
    }

    public function setFrom(string $address, string $name = '', bool $auto = false): static {
        try {
            $this->mail->setFrom($address, $name, $auto);
        } catch (Exception $e) {
            throw new InvalidArgumentException();
        }
        return $this;
    }

    public function setReplyTo(string|array $addresses, $name = ''): static {
        if (is_array($addresses)) {
            foreach ($addresses as $address) {
                try {
                    if (is_array($address)) {
                        $this->mail->addReplyTo($address[0], $address[1]);
                    } else {
                        $this->mail->addReplyTo($address);
                    }
                } catch (Exception $e) {
                    throw new InvalidArgumentException();
                }
            }
        } else {
            try {
                $this->mail->addReplyTo($addresses);
            } catch (Exception $e) {
                throw new InvalidArgumentException();
            }
        }
        return $this;
    }

    public function setAddress(string|array $recipients): static {
        if (is_array($recipients)) {
            foreach ($recipients as $recipient) {
                try {
                    if (is_array($recipient)) {
                        $this->mail->addAddress($recipient[0], $recipient[1]);
                    } else {
                        $this->mail->addAddress($recipient);
                    }
                } catch (Exception $e) {
                    throw new InvalidArgumentException();
                }
            }
        } else {
            try {
                $this->mail->addAddress($recipients);
            } catch (Exception $e) {
                throw new InvalidArgumentException();
            }
        }
        return $this;
    }

    public function setCC(string|array $recipients): static {
        if (is_array($recipients)) {
            foreach ($recipients as $recipient) {
                try {
                    if (is_array($recipient)) {
                        $this->mail->addCC($recipient[0], $recipient[1]);
                    } else {
                        $this->mail->addCC($recipient);
                    }
                } catch (Exception $e) {
                    throw new InvalidArgumentException();
                }
            }
        } else {
            try {
                $this->mail->addCC($recipients);
            } catch (Exception $e) {
                throw new InvalidArgumentException();
            }
        }
        return $this;
    }

    public function setBCC(string|array $recipients): static {
        if (is_array($recipients)) {
            foreach ($recipients as $recipient) {
                try {
                    if (is_array($recipient)) {
                        $this->mail->addBCC($recipient[0], $recipient[1]);
                    } else {
                        $this->mail->addBCC($recipient);
                    }
                } catch (Exception $e) {
                    throw new InvalidArgumentException();
                }
            }
        } else {
            try {
                $this->mail->addBCC($recipients);
            } catch (Exception $e) {
                throw new InvalidArgumentException();
            }
        }
        return $this;
    }

    public function addAttachment(string|array $attachments): static {
        if (is_array($attachments)) {
            foreach ($attachments as $attachment) {
                try {
                    $this->mail->addAttachment($attachment);
                } catch (Exception $e) {
                    throw new InvalidArgumentException();
                }
            }
        } else {
            try {
                $this->mail->addAttachment($attachments);
            } catch (Exception $e) {
                throw new InvalidArgumentException();
            }
        }
        return $this;
    }

    public function setSubject(string $subject): static {
        $this->mail->Subject = $subject;
        return $this;
    }

    public function setTemplate(string $templateName, array $args = []): static {
        try {
            $this->mail->isHTML(true);
            if (str_contains($templateName, '.')) {
                $templateName = str_replace('.', '/', $templateName);
            }
            $content = file_get_contents(CoreHelper::getAlias('@common') . 'components/mailer/template/' . $templateName . '.html');
            foreach ($args as $key => $value) {
                $content = str_replace('{{' . $key . '}}', $value, $content);
            }
            $content = str_replace('{{copyright_year}}', date('Y'), $content);
            $content = str_replace('{{app_name}}', Application::$GLOBALS['APP_NAME'], $content);
            $content = str_replace('{{app_link}}', ((empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST']), $content);
            $content = str_replace('{{email_subject}}', $this->mail->Subject, $content);
            $this->mail->Body = $content;
        } catch (Exception $e) {
            throw new InvalidArgumentException();
        }
        return $this;
    }

    public function setBody(string $body): static {
        $this->mail->Body = $body;
        return $this;
    }

    public function send(): true {
        try {
            if ($this->mail->send()) {
                return true;
            } else {
                throw new InvalidArgumentException();
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException();
        }
    }
}