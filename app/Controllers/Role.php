<?php

namespace App\Controllers;

use App\Models\RoleModel;
use CodeIgniter\Controller;

class Role extends Controller
{
    protected $RoleModel;
    protected $session;

    public function __construct()
    {
        $this->RoleModel = new RoleModel();
        helper('form');
        $this->session = \Config\Services::session();
    }

    public function profilesmt()
    {
        $userId = $this->session->get('user_id');
        $user = $this->RoleModel->getUserById($userId);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User with ID $userId not found");
        }

        $data['user'] = $user;
        $data['pageTitle'] = 'Profile SMT Line';

        echo view('admnsmt/profilesmt', $data);
    }

    public function profilefa()
    {
        $userId = $this->session->get('user_id');
        $user = $this->RoleModel->getUserById($userId);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User with ID $userId not found");
        }

        $data['user'] = $user;
        $data['pageTitle'] = 'Profile FA line';

        echo view('admnfa/profilefa', $data);
    }

    public function profilescrap()
    {
        $userId = $this->session->get('user_id');
        $user = $this->RoleModel->getUserById($userId);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User with ID $userId not found");
        }

        $data['user'] = $user;
        $data['pageTitle'] = 'Profile Admin Scrap';

        echo view('admnscrap/profilescrap', $data);
    }

    public function updatePasswordsmt()
    {
        $userId = $this->session->get('user_id');
        $currentPassword = $this->request->getPost('currentPassword');
        $newPassword = $this->request->getPost('newPassword');

        $user = $this->RoleModel->getUserById($userId);

        if ($user['password'] !== $currentPassword) {
            $this->session->setFlashdata('error', 'Password lama salah');
            return redirect()->back()->withInput();
        }

        $updateStatus = $this->RoleModel->update($userId, ['password' => $newPassword]);

        if ($updateStatus) {
            $this->session->setFlashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->setFlashdata('error', 'Terjadi kesalahan saat mengubah password');
        }

        return redirect()->to('/admnsmt/profilesmt');
    }

    public function updatePasswordfa()
    {
        $userId = $this->session->get('user_id');
        $currentPassword = $this->request->getPost('currentPassword');
        $newPassword = $this->request->getPost('newPassword');

        $user = $this->RoleModel->getUserById($userId);

        if ($user['password'] !== $currentPassword) {
            $this->session->setFlashdata('error', 'Password lama salah');
            return redirect()->back()->withInput();
        }

        $updateStatus = $this->RoleModel->update($userId, ['password' => $newPassword]);

        if ($updateStatus) {
            $this->session->setFlashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->setFlashdata('error', 'Terjadi kesalahan saat mengubah password');
        }

        return redirect()->to('/admnfa/profilefa');
    }

    public function updatePasswordscrap()
    {
        $userId = $this->session->get('user_id');
        $currentPassword = $this->request->getPost('currentPassword');
        $newPassword = $this->request->getPost('newPassword');

        $user = $this->RoleModel->getUserById($userId);

        if ($user['password'] !== $currentPassword) {
            $this->session->setFlashdata('error', 'Password lama salah');
            return redirect()->back()->withInput();
        }

        $updateStatus = $this->RoleModel->update($userId, ['password' => $newPassword]);

        if ($updateStatus) {
            $this->session->setFlashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->setFlashdata('error', 'Terjadi kesalahan saat mengubah password');
        }

        return redirect()->to('/admnscrap/profilescrap');
    }

}
