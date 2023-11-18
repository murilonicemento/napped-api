<?php

namespace App\Controllers;

use App\Models\User;

class UserController {
  public static function updateUser($id, $name, $email, $password) {
    try {
      $user = new User();
      $isUpdated = $user->update($id, $name, $email, password_hash($password, PASSWORD_DEFAULT));

      return $isUpdated ? ["message" => "Dados do usuário alterado com sucesso.", "statusCode"  => 200] : ["error" => ["message" => "Erro ao atualizar dados do usuário."], "statusCode" => 400];
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public static function deleteUser($id) {
    try {
      $user = new User();
      $data = $user->delete($id);

      return $data > 0 ? ["message" => "Usuário deletado com sucesso.", "statusCode" => 200] : ["error" => ["message" => "Erro ao deletar usuário. Talvez usuário já tenha sido deletado"], "statusCode" => 400];
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }
}
