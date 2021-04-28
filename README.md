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
| Autofetch::database($table, $time - in seconds) | Lists all the results from the table you mention|
| Autofetch::result($table, $type (first/last), $time - in seconds) | Lists only the first/last result from the table you mention|
| Autofetch::select($table, $selected_fields, $time - in seconds) | Lists all the results from the table you mention, but only the mentioned fields|
| Autofetch::top($table, $orderby, $number_of_results, $time - in seconds, $type) | Lists all the results from the table you mention, but only the mentioned fields|
| Autofetch::lazy($table, $orderby, $number_of_results, $time - in seconds) | Lazy-lists all the results from the table you mention, but only as much results as you mentioned|
   
## Usage

Now you can start using the package.

### 1. Include it in your controller

 ```php
use RobertSeghedi\LAS\Models\LAS;
  ```
   
### 2. Start using the tools

```php
public function fetch_table($table = null)
{
    $x = Autofetch::database($table);
    return $x;
}
```
### 3. Do whatever you want with the data

Follow this package for future updates
