# hauntpet/auth

Add the ability to authenticate using HauntID.

## Documentation
### Installation
```bash
composer require hauntpet/auth
```

### Setup
Create an account with [haunt.pet](https://haunt.pet), then create a new **External Game** with your websites url.

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
