<?php

namespace App\Controllers;

use App\Models\Auth;
use Firebase\JWT\JWT;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class AuthController {
  public static function registerUser($email, $name, $password) {
    try {
      $auth = new Auth();

      $token = self::generateToken();

      $newUser = ["user" => $auth->register($email, $name, password_hash($password, PASSWORD_DEFAULT), $token)];

      if (!$newUser["user"]) return ["error" => ["message" => "Erro ao cadastrar usuário. Verifique se já é cadastrado ou entre em contato conosco."], "statusCode" => 400];

      $newUser["message"] = "Usuário cadastrado com sucesso.";
      $newUser["statusCode"] = 201;

      return $newUser;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public static function generateToken() {
    $key = $_ENV["JWT_KEY"];
    $payload = [
      'iss' => 'http://example.org',
      'aud' => 'http://example.com',
      'iat' => 1356999524,
      'nbf' => 1357000000
    ];

    $headers = [
      'x-forwarded-for' => 'www.google.com'
    ];

    $jwt = JWT::encode($payload, $key, 'HS256', null, $headers);

    return $jwt;
  }

  public static function verifyToken($id, $userToken) {
    $auth = new Auth();

    $token = $auth->validateToken($id);

    return empty($token) || $userToken !== $token ? ["error" => ["message" => "Token inválido."], "statusCode" => 401] : true;
  }

  public static function sendMail($email, $name) {
    $mail = new PHPMailer(true);

    try {
      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  //Enable verbose debug output
      $mail->isSMTP(true);                                    //Send using SMTP
      $mail->Host       = $_ENV["MAILER_HOST"];               //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                               //Enable SMTP authentication
      $mail->Username   = $_ENV["MAILER_USERNAME"];           //SMTP username
      $mail->Password   = $_ENV["MAILER_PASSWORD"];           //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        //Enable implicit TLS encryption
      $mail->Port       = 587;                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $mail->setFrom($_ENV["MAILER_USERNAME"], "Napped");
      $mail->addAddress($email, $name);                     //Add a recipient

      //Attachments
      $mail->addAttachment("/var/tmp/file.tar.gz");         //Add attachments
      $mail->addAttachment("/tmp/image.jpg", "new.jpg");    //Optional name

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = "Bem-vindo ao Napped, $name!";
      $mail->Body    = "
        <p>Olá, $name</p>
        <p>Bem-vindo ao Napped, sua fonte de informações sobre o mundo nerd. Aqui você encontrará detalhes sobre séries, filmes, animes e jogos.</p>
        <p>Continue explorando e aproveitando o melhor do universo geek!</p>
        <p>Atenciosamente,<br>Equipe Napped!</p>
      ";
      $mail->AltBody = "Bem-vindo ao Projeto Napped! O Napped é uma fonte de informações sobre o mundo nerd, abrangendo séries, filmes, animes e jogos. Continue explorando e aproveitando o melhor do universo geek! Atenciosamente, Equipe Napped!";

      $mail->send();

      return ["message" => "E-mail enviado com sucesso."];
    } catch (Exception $exc) {
      return ["message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
    }
  }

  public static function loginUser($email, $password) {
    try {
      $auth = new Auth();
      $data = ["user" => $auth->login($email)];

      if (!$data["user"]) return ["error" => ["message" => "Usuário não cadastrado ou credenciais incorretas."], "statusCode" => 400];

      if (!password_verify($password, $data["user"]["password"])) return ["error" => ["message" => "Usuário ou senha inválidos. Verifique suas credenciais."], "statusCode" => 401];

      $data["message"] = "Login bem-sucedido.";
      $data["statusCode"] = 200;

      return $data;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }
}
