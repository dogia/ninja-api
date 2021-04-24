<?php

namespace App\Models;

use CodeIgniter\Model;

class CuentasModel extends Model
{
    protected $table      = 'cuentas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['email', 'password', 'nombres', 'apellidos', 'telefono'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'email' => 'required|valid_email|max_length[255]|is_unique[cuentas.email]',
        'password' => 'required|min_length[8]',
        'nombres' => 'required|alpha_numeric_space|min_length[3]',
        'apellidos' => 'required|alpha_numeric_space|min_length[3]',
        'telefono' => 'required|min_length[5]'
    ];
    protected $validationMessages = [
        'email' => [
            'required' => 'El campo email está vacío',
            'valid_email' => 'El email no tiene un formato válido',
            'max_length' => 'El email contiene más de 255 caracteres',
            'is_unique' => 'El email de la cuenta ya está en uso'
        ],
        'password' => [
            'required' => 'El campo password está vacío',
            'min_length' => 'El campo password no contiene una longitud suficiente',
        ],
        'nombres' => [
            'required' => 'El o los nombres son obligatorios',
            'alpha_numeric_space' => 'El nombre contiene caracteres extraños',
            'min_length' => 'Nombre inválido'
        ],
        'apellidos' => [
            'required' => 'El o los apellidos son obligatorios',
            'alpha_numeric_space' => 'El apellido contiene caracteres extraños',
            'min_length' => 'Apellidos inválidos'
        ],
        'telefono' => [
            'required' => 'El teléfono es obligatorio',
            'min_length' => 'El telefono no es válido'
        ]
    ];
    protected $skipValidation     = false;
}
