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

            'address_street.required' => 'O campo rua é obrigatório.',
            'address_street.max' => 'O campo rua não deve ter mais que :max caracteres.',

            'address_number.required' => 'O campo número é obrigatório.',
            'address_number.integer' => 'O campo número deve ser um número inteiro.',

            'address_complement.required' => 'O campo complemento é obrigatório.',
            'address_complement.max' => 'O campo complemento não deve ter mais que :max caracteres.',

            'address_neighborhood.required' => 'O campo bairro é obrigatório.',
            'address_neighborhood.max' => 'O campo bairro não deve ter mais que :max caracteres.',
        ],
    ],
];
