# hauntpet/auth
Adds authentication functionality with **HauntID** to an application.

## Installation
`composer require hauntpet/auth`

### Configuration
Add your game to Haunt, this can be done on the [Games Page](https://haunt.pet/games/283400585537089). Once your game is approved you can generate a client id and client secret under the "Tokens" tab on the games page.
```env
HAUNT_ID="client-id"
HAUNT_SECRET="client-secret"
HAUNT_REDIRECT="https://your-site.com/haunt/callback"
```

## Usage

### Login Button
An easy to use, preformatted, button can be imported for your users to login with.
```php
use HauntPet\Auth\Facades\HauntIDDecoration;

HauntIDDecoration::loginButton();
```

### Login
Upon clicking to login with HauntID, you will need to send the user to be redirected to the Haunt application. This can be done easily with the HauntID package.

```html
<a href="/haunt">
    <!-- login button html -->
</a>
```
```php
use HauntPet\Auth\Facades\HauntID;

Route::get('/haunt', function () {
    return HauntID::redirect();
});
```

### Callback
Once authorized, or denied, Haunt will send the user to the redirect url you have set (e.g. "https://your-site.com/haunt/callback"). You can then fetch the user from the Haunt application and update/create a user for your site.

```php
use HauntPet\Auth\Facades\HauntID;

Route::get('/haunt/callback', function () {
    if(request()->has('error')) {
        return redirect('/');
    }

    $hauntUser = HauntID::user() // ['id', 'email', 'birthday', 'username'];

    $user = User::updateOrCreate([
        'haunt_id' => $hauntUser['id'],
    ], [
        'email' => $hauntUser['email'],
        'birthday' => $hauntUser['birthday'],
        'username' => $hauntUser['username'],
    ]);

    Auth::login($user);

    return redirect()->intended('/');
});
```
