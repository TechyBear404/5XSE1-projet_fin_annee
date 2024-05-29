<?php

function getContactRules()
{
  return [
    'rules' => [
      'firstName' => [
        'required' => true,
        'minLength' => 2,
        'maxLength' => 255,
      ],
      'lastName' => [
        'required' => true,
        'minLength' => 2,
        'maxLength' => 255,
      ],
      'email' => [
        'required' => true,
        'type' => 'email',
        'unique' => 'users'
      ],
      'message' => [
        'required' => true,
        'minLength' => 8,
        'maxLength' => 500,
      ],

    ],
    'inputNames' => [
      'firstName' => 'Prénom',
      'lastName' => 'Nom',
      'email' => 'Adresse email',
      'message' => 'Message'
    ],
    'errors' => [
      'required' => "Le champ %0% est requis.",
      'minLength' => "Le champ %0% doit contenir au moins %1% caractères.",
      'maxLength' => "Le champ %0% doit contenir au maximum %1% caractères.",
      'email' => "Le champ %0% doit contenir adresse email valide.",
      'passwordConfirm' => 'Les mots de passe ne correspondent pas.',
      'unique' => "Le champ %0% est déjà utilisé."
    ]
  ];
};
