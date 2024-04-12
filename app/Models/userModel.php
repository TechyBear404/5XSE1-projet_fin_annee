<?php

function getRules()
{
  return [
    "rules" => [
      'pseudo' => [
        'required' => true,
        'minLength' => 2,
        'maxLength' => 255,
        'unique' => 'users'
      ],
      'email' => [
        'required' => true,
        'type' => 'email',
        'unique' => 'users'
      ],
      'pwd' => [
        'required' => true,
        'type' => 'password',
        'minLength' => 8,
        'maxLength' => 72,
      ]
    ],
    "errors" => [
      'required' => "Le champ %0% est requis.",
      'minLength' => "Le champ %0% doit contenir au moins %1% caractères.",
      'maxLength' => "Le champ %0% doit contenir au maximum %1% caractères.",
      'email' => "Le champ %0% doit être une adresse email valide.",
      'unique' => "Le champ %0% est déjà utilisé."
    ]
  ];
}
