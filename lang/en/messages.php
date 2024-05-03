<?php

return [
    'errors' => [
        'error' => 'An error occurred. Please try again later.',
        'validation_errors' => 'Validation errors',
        'register_failed' => 'User registration failed',
        'login_failed' => 'Login failed. Please try again later.',
        'refresh_token_failed' => 'Failed to refresh token',
        'wrong_credentials' => 'Please check your login credentials',
        'unauthorized' => 'Unauthorized',
        'permission_denied' => 'This action is not permitted',
        'data_not_found' => 'Data not found',
        'route_not_found' => 'Route not found',
        'invalid_method' => 'This method is not supported for the URL',
        'login_blocked' => 'Blocked for {{minutes}} mins. Exceeded 3 login attempts. Retry after {{minutes}} mins.',
        'verification_email_sent' => 'You haven\'t validated your account yet. We\'ve sent you a new validation link. Please validate your account before logging in.',
        'headers' => [
            'missing_invalid' => 'Missing/invalid header',
            'source_required' => 'Source header is required',
            'source_invalid' => 'Source header is invalid',
        ],
        'disabled_by_admin' => 'This aacount is banned from the administation',
        'forgot_password' => '<p>Nous vous informons que le lien de réinitialisation de votre mot de passe a été envoyé à votre boîte mail enregistrée. Veuillez vérifier votre messagerie pour accéder au lien et procéder à la réinitialisation.<p>
        <p>Si vous ne trouvez pas l\'e-mail dans votre boîte de réception, nous vous recommandons de vérifier votre dossier de courrier indésirable (spam). Parfois, les e-mails peuvent atterrir là par erreur.</p>
        <p>En cas de difficultés ou si vous avez besoin d\'aide supplémentaire, n\'hésitez pas à nous contacter. Notre équipe de support est là pour vous aider à tout moment.</p>
        <p>Merci de votre confiance en nos services.</p>',

        'token_expired' => 'Your token has expired. Please try again.',
        'wrong_token' => 'Your token is wrong.',
        'incorrect_new_password' => 'Nouveau mot de passe déjà utilisé',


    ],
    'success' => [
        'success' => 'Operation completed successfully',
        'register_success' => 'User registered successfully',
        'login_success' => 'User logged in successfully',
        'refresh_token_success' => 'Token refreshed successfully',
        'password_updated' => 'Votre mot de passe a été modifié avec succès',

    ]
];
