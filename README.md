# Personal proyect

This personal proyect is my little place un github and online word to make thouse little proyects for learning and making people around me life easier.

There are some proyects that when I have time to I want to make:

- API endpoint for ALexa that searchs when is going to be the blood donors bus in the place that is provided. This works having data from "[Donantes de sangre Euskadi]"".
- OPE exams tester. I had in pass some Telegram bots working with exams data that I get from official places and internet. I want to make API and admin panel for exams, based in easyadmin
- Pintxo-bot: I had a Telegram bot that had questions of [Trivial IRC] so in a group chat you can play to that trivial as you can play with IRC

# Alexa Blod Donors API

There is and endpoint in witch you can obtain where is the bus. To configure it you must include BLOOD_DONORS_BY_PLACE_WS_URL variable in .env file. This URL is private so you can't make this in your repo.
```sh
POST http://personal.proyect/api/bloddonors/
Content-Type: application/json

{
  "place":"Basauri"
}
```

All code for these endpoint is made in src/BloodDonors forlder and it test are in tests/BloodDonors.

Hexagonal architecture has been used to make these endpoint.


[Donantes de sangre Euskadi]: <http://www.donantes2punto0.eus/es/>
[Trivial IRC]: <https://www.trivial-irc.es/>
 
