# Personal project

This personal project is my little place un GitHub and online word to make those little projects for learning and making people around me life easier.

Project list:

- Blood donors: API endpoint for Alexa that search when is going to be the blood donors bus in the place that is provided. This works having data from "[Donantes de sangre Euskadi]"".
- Exam quiz and management: And API and admin panel for exams, based in easyadmin and a Quiz web to make those exams
- OpeDue: OPE exam maker in Telegram.
- School menu: API endpoint for Alexa that can provides information to it in order to know what do they have in school menu


## Alexa Blood Donors API

There is and endpoint in witch you can obtain where is the bus. To configure it you must include BLOOD_DONORS_BY_PLACE_WS_URL variable in .env file. This URL is private so you can't make this in your repo.
```sh
POST http://personal.proyect/api/bloddonors/
Content-Type: application/json

{
  "place":"Basauri"
}
```

All code for this endpoint is made in src/BloodDonors folder, and it tests are in tests/BloodDonors.

Hexagonal architecture has been used to make this endpoint.

[Blood Donors Skill in Amazon market]

## Exam quiz and management

The core of this project is the database of exams. It is based on the posibility to make quiz on diferent topics. It has already exams of these topics:

- Ope Osakidetza in computer science
- Ope Osakidetza in nursing
- Ope Osakidetza other sanitary professions
- EGA (euskera)

The endpoints have been done using hexagonal architecture and the management is based in easyadmin.


## School menu

This project is make using hexagonal architecture and the management is based in easyadmin.

All the data for the menu is being provided in easyadmin panel and then an endpoint serve it to Alexa.

[School Skill in Amazon market]

[Donantes de sangre Euskadi]: <http://www.donantes2punto0.eus/es/>
[Blood Donors Skill in Amazon market]: <https://www.amazon.es/Donantes-de-sangre-Euskadi/dp/B082MG6Z3L>
[School Skill in Amazon market]: <https://www.amazon.es/Que-comen-en-Sofia-Taramona/dp/B08MWSFZKB>