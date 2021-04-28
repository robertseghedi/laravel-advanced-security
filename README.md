# Laravel Advanced Security
 One of the most optimized plugins for securing the Laravel users accounts.
 
 This is a fresh Laravel plugin which gets security data from your users and gives you the chance to store it crypted or decrypted, with no stress. Educational purposes only / other purposes but on your own liability.
 
 ## Instalation
 First, you have to install the package using composer in your project root folder:
 ```
 composer require robertseghedi/laravel-advanced-security
 ```
  Edit your root-project's composer.json and add
  ```json
 "autoload": {
    "psr-4": {
        "RobertSeghedi\\LAS\\": "packages/robertseghedi/laravel-advanced-security/src"
    }
},
   ```
 Then, you have to add the provider to your ```config/app.php``` like that:
 ```php
 // your providers

RobertSeghedi\LAS\LASProvider::class,
 ```
 
## Information
 
| Command name | What it does |
| --- | --- |
| LAS::ip() | Gets the authenticated user's IP address|
| LAS::purify($data) | Purifies some string|
| LAS::os() | Gets the authenticated user's operating system|
| LAS::browser() | Gets the authenticated user's browser|
| LAS::file_size($kb) | Transforms numbered KB to **100 GB**|
| LAS::password($length) | Generates random numbered-lettered password in the mentioned length - default is 10 |
| LAS::pin($length) | Generates a custom PIN in the mentioned length - default is 4|
| LAS::ssl() | Returns if the actual site is secured or not (SSL)|
| LAS::log($user, $text) | Inserts an encrypted log with text to a user|
| LAS::logs($user, $results, $time) | Efficiently fetches & caches user logs based on the mentioned criteria|
| LAS::all_logs($results, $time) | Efficiently fetches & caches all the secure logs|
   
## Usage

Now you can start using the package.

### 1. Include it in your controller

 ```php
use RobertSeghedi\LAS\Models\LAS;
  ```
   
### 2. Start using the tools

```php
public function add_post(Request $req)
{
    $post = new Post();
    $post->title = $req->input('title');
    $post->description = $req->input('description');
    $post->user = Auth::user()->id;
    $post->ip = LAS::ip(); // grabs the user IP
    $post->browser = LAS::browser(); // grabs the user browser
    $post->os = LAS::os(); // grabs the user OS
    $saved_post = $post->save();
    if($saved_post) return redirect()->back()->with('success', 'Article posted.');
}
```

```php
public function insert_log($user_id = null)
{
    $user = User::find($user_id);
    $log = LAS::log($user_id, "$user->name joined the chat.");
    if($log) return redirect()->back();
}
```
### 3. Do whatever you want with the data

Follow this package for future updates
