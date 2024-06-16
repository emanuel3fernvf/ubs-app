<?php

return [
    'patient' => [
        'base' => [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome não deve ter mais que :max caracteres.',

            'cpf.required' => 'O campo CPF é obrigatório.',

            'birth_date.required' => 'O campo data de nascimento é obrigatório.',
            'birth_date.date' => 'O campo data de nascimento deve ser uma data válida.',

            'phone.required' => 'O campo telefone é obrigatório.',

            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'O status selecionado é inválido.',
        ],
    ],
    'professional' => [
        'base' => [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome não deve ter mais que :max caracteres.',

            'crm.required' => 'O campo CRM é obrigatório.',

            'user_id.required' => 'O campo usuário é obrigatório.',
            'user_id.integer' => 'O campo usuário deve ser um número inteiro.',
            'user_id.in' => 'Usuário inválido.',

            'specialty_id.required' => 'O campo especialidade é obrigatório.',
            'specialty_id.integer' => 'O campo especialidade deve ser um número inteiro.',
            'specialty_id.in' => 'Especialidade inválida.',

            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'O status selecionado é inválido.',
        ],
    ],
    'specialty' => [
        'base' => [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome não deve ter mais que :max caracteres.',

            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'O status selecionado é inválido.',
        ],
    ],
    'address' => [
        'base' => [
            'city.required' => 'O campo cidade é obrigatório.',
            'city.max' => 'O campo cidade não deve ter mais que :max caracteres.',

            'street.required' => 'O campo rua é obrigatório.',
            'street.max' => 'O campo rua não deve ter mais que :max caracteres.',

            'number.required' => 'O campo número é obrigatório.',
            'number.integer' => 'O campo número deve ser um número inteiro.',

            'complement.required' => 'O campo complemento é obrigatório.',
            'complement.max' => 'O campo complemento não deve ter mais que :max caracteres.',

            'neighborhood.required' => 'O campo bairro é obrigatório.',
            'neighborhood.max' => 'O campo bairro não deve ter mais que :max caracteres.',
        ],
    ],
    'unit' => [
        'base' => [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome não deve ter mais que :max caracteres.',

            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'O status selecionado é inválido.',
        ],
    ],
];
