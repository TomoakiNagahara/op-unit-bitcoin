Generate bitcoin address
===

 Bitcoin addresses are generated differently for each wallet.
 Even if the label is the same, a different address will be generated for each wallet.

```php
static function OP\UNIT\Bitcoin::Address(string $label=null){
  //  Always convert to md5.
  $label = md5($label);
  //  Automatically generate new address always by label.
  try{
    $address = self::RPC('getaddressesbylabel',[$label]);
  }cache(){
    $address = self::RPC('getnewaddress',[$label]);
  }
  //  Return result.
  return $address;
}
```

| key     | meaning |
| ------- | ------- |
| label   | Generate bitcoin address by label |
