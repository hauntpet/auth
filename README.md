# hauntpet/auth

Add the ability to authenticate using HauntID.

## Documentation
### Installation
```bash
composer require hauntpet/auth
```

### Setup
1. Create an account with [haunt.pet](https://haunt.pet).
2. On the settings page add a new external game with your website's url.
3. Select to edit the newly created game and generate an access token.
4. Set the environment variable `HAUNT_ACCESS_TOKEN` as the access token.

### Methods
```php
use HauntPet\Auth\Facades\HauntID;

$data = [
    'email' => $request->email,
    'password' => $request->password,
    'username' => $request->username,
    'birthday' => $request->birthday,
];
$response = HauntID::register($data);

if($response->ok()) {
    User::create(array_merge($data, [
        'haunt_id' => $response->json()['id'],
    ]));

    ...
}
```

```php
use HauntPet\Auth\Facades\HauntID;

$data = [
    'email' => $request->email,
    'password' => $request->password,
];
$response = HauntID::login($data);

if($response->ok()) {
    $data = $response->json();
    $attributes = array_merge(Arr::except($data, ['id', 'activation_token', 'created_at', 'updated_at']), [
        'password' => Hash::make(request()->password),
    ]);
    $user = User::firstOrCreate(['haunt_id' => $data['id'], $attributes]);

    ...
}
```
