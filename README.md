# MessageBird / Laravel Notifications

This package adds the ability to send notifications to WhatsApp, Facebook Messenger and SMS via MessageBird as a valid Laravel Notification, making life easier to utilise notifications and queueing.

## Usage

To use this package, run `composer require messagebird/laravel-notification`. Once it completes, you can implement the following methods on your notification:

* `toMessageBirdWhatsApp`
* `toMessageBirdFacebook`
* `toMessageBirdSms`

See [examples/Notification/MerryChristmas.php](examples/Notification/MerryChristmas.php) for a complete example.

To send a notification, specify the channel you'd like to use:

```php
// To a user
$user->notify(new \App\Notifications\MerryChristmas());

// To any person
Notification::route(
    'messagebird-whatsapp',
    'YOUR_NUMBER'
)->notify(new \App\Notifications\MerryChristmas());
```

The available channels are:

* `messagebird-sms`
* `messagebird-whatsapp`
* `messagebird-facebook`
* `messagebird-viber_service_msg`

As each notification receives a `$notifiable` (usually a user) it can decide how best to route the information. In this case, it checks the `via_whatsapp` property on the user and sends via WhatsApp if it's true. Otherwise it falls back to email

```
public function via($notifiable)
{
    return $notifiable->via_whatsapp ? ['messagebird-whatsapp'] : ['mail'];
}
```

### Message Types

MessageBird supports multiple message types, depending on the channel that you're sending to. The `Text` type is the safest if you want to deliver to all channels:

```
public function toMessageBirdWhatsApp($notifiable)
{
    return (new \MessageBird\Notifications\Message\Text)
        ->content('This is a message being sent to WhatsApp');
}
```

### Caveats

For some channels you need to send a templated message before you can send a free text message due to spam control rules. Here's an example of how to use a preapproved template intended for two-factor authentication purposes:

```
public function toMessageBirdWhatsApp($notifiable)
{
    return (new \MessageBird\Notifications\Message\Template)
        ->name("whatsapp:hsm:technology:messagebird:verify")
        ->parameters([
            ["default" => "Your Brand"],
            ["default" => "64873"],
            ["default" => "10"],
        ]);
}
```

If the recipient replies to your message, you can send them `Text` type messages without any issues

## Configuration

### Authentication

This notifications package is built on top of [Nexmo/laravel-notification](https://github.com/Nexmo/laravel-notification) and I've adepted it for MessageBird purposes.

For this to work, you need to set your base API URL for the MessageBird Programmable Conversations API and the Access Key from your MessageBird developer dashboard in the `.env` file:

```
MESSAGEBIRD_API_CONVERSATIONS_URL=api_url
MESSAGEBIRD_ACCESS_KEY=my_api_key
```

### Setting the `from` address

You can set a `from `address via the `.env` file. This package will look for provider specific entries before falling back to `MESSAGEBIRD_FROM`.

```
MESSAGEBIRD_FROM_SMS=""
MESSAGEBIRD_FROM_WHATSAPP=""
MESSAGEBIRD_FROM_MESSENGER=""
MESSAGEBIRD_FROM="" # This is the default if any of the above aren't set
```

Alternatively, you can set a `from` address for a single notification by calling the `->from()` method on a message:

```php
public function toMessageBirdWhatsApp($notifiable)
{
    return (new Text)->content('Merry Christmas!')->from("YOUR_ID");
}
```
