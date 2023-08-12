<?php namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use App\Models\UsernameModel;

class Auth extends Controller
{
    use ResponseTrait;

    public function login()
    {
        // Ambil data dari request menggunakan request object
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
    
        // Validasi input (disarankan menggunakan library validation)
        if (empty($username) || empty($password)) {
            return $this->failValidationErrors('Username and password are required.');
        }
    
        $usernameModel = new UsernameModel();
    
        // Cari pengguna berdasarkan username
        $user = $usernameModel->where('username', $username)->first();
    
        if (!$user) {
            return $this->failUnauthorized('Invalid username or password.');
        }
    
        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Invalid username or password.');
        }
    
        // Jika autentikasi berhasil, Anda dapat mengembalikan data yang diperlukan, misalnya token JWT atau data pengguna lainnya
        $responseData = [
            'user_id' => $user['id'],
            'username' => $user['username']
            // Anda dapat menambahkan lebih banyak data sesuai kebutuhan
        ];
    
        return $this->respond($responseData, 200);
    }
}
