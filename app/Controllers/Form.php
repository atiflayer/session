<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Form extends Controller
{
    public function index()
    {
        helper(['form', 'url']);

        if (! $this->validate([
            'username' => 'required',
            'password' => 'required|min_length[10]',
            'passconf' => 'required|matches[password]',
            'email'    => 'required|valid_email',
            ])) {
            echo view('Signup', [
                'validation' => $this->validator,
            ]);
        } else {
            echo view('Success');
        }
    }
}