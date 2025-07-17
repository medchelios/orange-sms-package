# Orange SMS Package for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tmoh/orange-sms-package.svg)](https://packagist.org/packages/tmoh/orange-sms-package)
[![Total Downloads](https://img.shields.io/packagist/dt/tmoh/orange-sms-package.svg)](https://packagist.org/packages/tmoh/orange-sms-package)
[![License](https://img.shields.io/packagist/l/tmoh/orange-sms-package.svg)](https://github.com/medchelios/orange-sms-package/blob/main/LICENSE)

Package Laravel pour l'intégration de l'API SMS d'Orange. Envoyez des SMS, consultez le solde et les statistiques d'usage.

## ✨ Fonctionnalités

- 📱 Envoi de SMS avec formatage automatique
- 💰 Consultation du solde SMS
- 📊 Statistiques d'usage détaillées
- 📋 Historique des achats
- 🔐 Authentification OAuth automatique
- 🎭 Facade Laravel simple d'utilisation

## 🚀 Installation

```bash
composer require tmoh/orange-sms-package
```

Publiez la configuration :
```bash
php artisan vendor:publish --tag=orange-sms-config
```

## ⚙️ Configuration

Ajoutez dans votre `.env` :

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
    '+224624000000',
    'Votre code de vérification est 123456',
    'MyApp'
);

if ($response->success) {
    echo "SMS envoyé avec succès!";
} else {
    echo "Erreur: " . $response->error->text ?? 'Erreur inconnue';
}

// Consulter le solde
$balance = OrangeSms::viewSmsBalance();

// Consulter les statistiques
$usage = OrangeSms::viewSmsUsage();

// Historique des achats
$history = OrangeSms::viewPurchaseHistory();
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

        return response()->json($response);
    }
}
```

## 🧪 Tests

```bash
composer test
```

## 📄 Licence

MIT License

## 📞 Support

- 📧 Email : toure1206@gmail.com
- 🐛 Issues : [GitHub Issues](https://github.com/medchelios/orange-sms-package/issues)

---

⭐ Si ce package vous a aidé, n'hésitez pas à le star sur GitHub !
