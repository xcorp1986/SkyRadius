# SkyRadius

The first (known to me) RADIUS server which was implemented natively in PHP! Based on the incredible
possibilities of ReactPHP I was able to write this library. Currently RFC2865 + RFC2868 are implemented, if you want to contribute, you
should follow up with RFC2866 + RFC2867 (I'm always happy about PRs ;) ).

## Example

Enter `./Example/` directory:

```
cd ./Example/
```

Load vendor Libs:

```
composer install
```

Install `radclient` from `freeRADIUS`-Project:

```
sudo apt install freeradius-utils
```

Run `SkyDiablo/SkyRadius` Example-Server:

```
php radius.php
```

Run the `radclient` in an separate console session

```
echo "User-Name=test,User-Password=mypass,Framed-Protocol=PPP" | radclient -x 127.0.0.1:3500 auth test

Sent Access-Request Id 31 from 0.0.0.0:52235 to 127.0.0.1:3500 length 50
        User-Name = "test"
        User-Password = "mypass"
        Framed-Protocol = PPP
        Cleartext-Password = "mypass"
Received Access-Accept Id 31 from 127.0.0.1:3500 to 0.0.0.0:0 length 110
        Reply-Message = "Echo Test-Radius-Server"
        User-Name = "test"
        User-Password = "ѣ\3332a\274\016({\312A\257P\3623\214\273-\342\331Z\035\024:\267\254i#h'\200\262\021f˷c\305y2*\201qlNh\234\236u\377\207"
        Framed-Protocol = PPP 
```

* As you can see, the echo is missing the attribute `Cleartext-Password` -> it isn't implemented by default, yet ;)
* Also ignore the cryptic looking `User-Password` attribute, server-side encrypting for this attribute is also missing. But given by RFC, the server should never be doing this! 

## Benchmark

In extension to the example given above, you can stress-test your `SkyDiablo/SkyRadius` instance by improving the requests:

```
echo "User-Name=test,User-Password=mypass,Framed-Protocol=PPP" | radclient -n 1000 -c 99999999999 127.0.0.1:3500 auth test
```

In my setup I was able to handle 15k requests/sec at 90% CPU load with the demo-server mentioned here. For this I have 
started the radclient 5 times with `-n 40000` on the same server and piped the output into `> /dev/null`. Used CPU: `Intel(R) Xeon(R) Gold 6140 CPU @ 2.30GHz` with 2 cores:

![15k Benchmark Test](./Example/15k-test-result.png?raw=true "15k Benchmark Test")

## TODOs

- Attribute Dictionary Loader
  - YAML
  - JSON
- UnitTest

## Thanks

- Thank you [reactPHP](https://reactphp.org/) for your brilliant work!
- [BaconFist](https://github.com/BaconFist) has provided the benchmark server, thank you!
