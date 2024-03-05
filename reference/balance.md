Get balance can per address.
===

```php
static function Balance(string $address=''){
  //  If passed bitcoin address.
  if( $address ){
    //  That just a rapper.
    $balance = self::Received($address);
  }else{
    //  Get all the balances in wallet.
    $balance = self::RPC('getbalance');
  }
  //  Return result.
  return $balance;
}
```

| key     | meaning |
| ------- | ------- |
| address | per address |
