<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Orange SMS Package for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tmoh/orange-sms-package.svg)](https://packagist.org/packages/tmoh/orange-sms-package)
[![Tests](https://github.com/medchelios/orange-sms-package/workflows/Tests/badge.svg)](https://github.com/medchelios/orange-sms-package/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/tmoh/orange-sms-package.svg)](https://packagist.org/packages/tmoh/orange-sms-package)
[![License](https://img.shields.io/packagist/l/tmoh/orange-sms-package.svg)](https://github.com/medchelios/orange-sms-package/blob/main/LICENSE)

Un package Laravel complet pour l'intégration de l'API SMS d'Orange. Permet d'envoyer des SMS, consulter le solde, les statistiques d'usage et l'historique des achats.

## ✨ Fonctionnalités

- 🔐 **Authentification OAuth** automatique avec l'API Orange SMS
- 📱 **Envoi de SMS** avec formatage automatique des numéros
- 💰 **Consultation du solde** SMS disponible
- 📊 **Statistiques d'usage** détaillées
- 📋 **Historique des achats** SMS
- 🛡️ **Gestion d'erreurs** robuste avec DTOs
- 🎭 **Facade Laravel** pour une utilisation simplifiée
- ⚙️ **Configuration flexible** via variables d'environnement
- 🧪 **Tests complets** avec PHPUnit et Orchestra Testbench

## 📋 Prérequis

- PHP 8.2 ou supérieur
- Laravel 10.x, 11.x ou 12.x
- Compte Orange SMS API avec credentials

## 🚀 Installation

### 1. Installer le package

```bash
composer require tmoh/orange-sms-package
```

### 2. Publier la configuration

```bash
php artisan vendor:publish --tag=orange-sms-config
```

### 3. Configurer les variables d'environnement

Ajoutez ces variables dans votre fichier `.env` :

```env
ORANGE_SMS_BASE_URL=https://api.orange.com
ORANGE_SMS_BASIC_TOKEN=your_basic_token_here
ORANGE_SMS_DEFAULT_SENDER_ADDRESS=+224624000000
ORANGE_SMS_DEFAULT_SENDER_NAME=SMS 987519
ORANGE_SMS_TIMEOUT=30
```

## 📖 Utilisation

### Via la Facade

```php
use Tmoh\OrangeSmsPackage\Facades\OrangeSms;

// Envoyer un SMS
$response = OrangeSms::sendSms(
    recipientAddress: '+224624000000',
    message: 'Votre code de vérification est 123456',
    senderName: 'MyApp'
);

if ($response->success) {
    echo "SMS envoyé avec succès!";
    echo "Message ID: " . $response->smsResponse->resourceURL;
} else {
    echo "Erreur: " . $response->error->text ?? 'Erreur inconnue';
}

// Consulter le solde
$balance = OrangeSms::viewSmsBalance();
if ($balance->success) {
    echo "Solde disponible: " . $balance->balance->availableUnits;
}

// Consulter les statistiques d'usage
$usage = OrangeSms::viewSmsUsage();
if ($usage->success) {
    echo "SMS envoyés ce mois: " . $usage->usage->totalCount;
}

// Consulter l'historique des achats
$history = OrangeSms::viewPurchaseHistory();
if ($history->success) {
    foreach ($history->purchases as $purchase) {
        echo "Achat: " . $purchase->orderId . " - " . $purchase->units;
    }
}
```

### Via l'Injection de Dépendance

```php
use Tmoh\OrangeSmsPackage\Contracts\OrangeSmsServiceInterface;

class SmsController extends Controller
{
    public function __construct(
        private OrangeSmsServiceInterface $smsService
    ) {}

    public function sendSms(Request $request)
    {
        $response = $this->smsService->sendSms(
            $request->input('phone'),
            $request->input('message'),
            $request->input('sender_name')
        );

        return response()->json([
            'success' => $response->success,
            'message' => $response->smsResponse?->message ?? 'Erreur',
            'resource_url' => $response->smsResponse?->resourceURL ?? null
        ]);
    }
}
```

## 🔧 Configuration

### Variables d'environnement

| Variable | Description | Défaut |
|----------|-------------|---------|
| `ORANGE_SMS_BASE_URL` | URL de base de l'API Orange | `https://api.orange.com` |
| `ORANGE_SMS_BASIC_TOKEN` | Token Basic pour l'authentification | - |
| `ORANGE_SMS_DEFAULT_SENDER_ADDRESS` | Adresse d'expéditeur par défaut | - |
| `ORANGE_SMS_DEFAULT_SENDER_NAME` | Nom d'expéditeur par défaut | `SMS 987519` |
| `ORANGE_SMS_TIMEOUT` | Timeout des requêtes HTTP (secondes) | `30` |

### Configuration avancée

Vous pouvez modifier le fichier `config/orange_sms.php` pour des configurations personnalisées :

```php
return [
    'base_url' => env('ORANGE_SMS_BASE_URL', 'https://api.orange.com'),
    'basic_token' => env('ORANGE_SMS_BASIC_TOKEN'),
    'default_sender_address' => env('ORANGE_SMS_DEFAULT_SENDER_ADDRESS'),
    'default_sender_name' => env('ORANGE_SMS_DEFAULT_SENDER_NAME', 'SMS 987519'),
    'timeout' => env('ORANGE_SMS_TIMEOUT', 30),
];
```

## 📊 Structure des DTOs

### SendSmsResponseDto
```php
$response->success; // bool
$response->smsResponse; // SmsSuccessResponseDto|null
$response->error; // SmsErrorDto|null
```

### SmsSuccessResponseDto
```php
$response->smsResponse->address; // array
$response->smsResponse->senderAddress; // string
$response->smsResponse->message; // string
$response->smsResponse->resourceURL; // string
$response->smsResponse->senderName; // string|null
```

### SmsBalanceResponseDto
```php
$response->success; // bool
$response->balance; // SmsBalanceDto|null
$response->error; // SmsErrorDto|null
```

## 🧪 Tests

### Lancer les tests

```bash
composer test
```

### Tests disponibles

- ✅ Tests unitaires du service
- ✅ Tests de la Facade
- ✅ Tests d'intégration avec l'API
- ✅ Tests de gestion d'erreurs

## 🔍 Dépannage

### Erreurs courantes

1. **Erreur d'authentification**
   - Vérifiez que `ORANGE_SMS_BASIC_TOKEN` est correct
   - Assurez-vous que le token n'a pas expiré

2. **Erreur de format de numéro**
   - Les numéros doivent être au format international (+224...)
   - Le package formate automatiquement les numéros

3. **Erreur de nom d'expéditeur**
   - Le nom d'expéditeur est limité à 11 caractères
   - Seuls les caractères alphanumériques et espaces sont autorisés

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Fork le projet
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 🙏 Remerciements

- [Laravel](https://laravel.com) pour le framework
- [Orange SMS API](https://developer.orange.com/apis/sms) pour l'API
- [Orchestra Testbench](https://github.com/orchestral/testbench) pour les tests

## 📞 Support

Si vous avez des questions ou des problèmes :

- 📧 Email : toure1206@gmail.com
- 🐛 Issues : [GitHub Issues](https://github.com/medchelios/orange-sms-package/issues)
- 📖 Documentation : [Wiki](https://github.com/medchelios/orange-sms-package/wiki)

---

⭐ Si ce package vous a aidé, n'hésitez pas à le star sur GitHub !
