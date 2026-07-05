<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste utilisateurs - AgriConnect</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #111827; }
        h1 { font-size: 18px; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 6px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>Liste des utilisateurs - AgriConnect</h1>
    <p>Export généré le {{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Localisation</th>
                <th>Statut KYC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                @php
                    $profile = $user->role === 'producteur' ? $user->producteur : $user->acheteur;
                    $location = $user->role === 'producteur'
                        ? optional($profile)->localisation
                        : optional($profile)->adresseLivraison;
                    $status = $user->role === 'producteur' && empty(optional($profile)->kycValide) ? 'En attente' : 'Vérifié';
                @endphp
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $location ?? 'Non renseignée' }}</td>
                    <td>{{ $status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
