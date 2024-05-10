# Space App

L'Application Space est un projet conçu pour démontrer mes compétences techniques en PHP avec le framework Symfony. Son objectif est de permettre aux utilisateurs de se connecter à l'application en utilisant leur compte Google, afin de visualiser l'image du jour fournie par l'API de la NASA.

## Technologies utilisées

- **Langage de programmation :**
    - PHP 8.1

- **Framework :**
    - Symfony 6.1

- **Serveur :**
    - WampServer

- **Gestionnaire de dépendances :**
    - Composer (fourni par Mr Pétré lors des cours à l'Université de Lorraine)

- **Bibliothèques et bundles :**
    - **Twig :** Moteur de template utilisé avec Symfony pour générer des vues HTML plus facilement et de manière plus propre.
    - **Bootstrap :** Framework CSS utilisé pour le design et la mise en page des pages web de l'application.
    - **KnpUniversity OAuth2 Client Bundle :** Bundle Symfony permettant l'authentification OAuth2, utilisé pour la connexion avec Google.
    - **League OAuth2 Google :** Bibliothèque PHP pour l'authentification OAuth2 avec Google, utilisée en conjonction avec KnpUniversity OAuth2 Client Bundle.

## Utilisation

Pour utiliser le projet, vous avez deux options :

### 1. Utilisation en local via le dépôt Git

1. Clonez le dépôt Git sur votre machine :
   ```bash
   git clone https://github.com/AlexisDelazzari/php-test-apod.git
   ```

2. Copiez le fichier `.env` et renommez-le en `.env.local`.
   Adaptez les paramètres de connexion à votre base de données si nécessaire en vous basant sur le fichier `.env`.

3. Utilisez la commande suivante pour faire la requête API et remplir la base de données avec l'image du jour :
   ```bash
   php bin/console app:fetch-nasa-picture
   ```
   Cette commande remplit la base de données avec l'image du jour si aucune requête n'a été faite aujourd'hui.

### 2. Utilisation du site en ligne

Vous pouvez également utiliser le projet en ligne en le consultant sur le lien suivant :
[https://alexisdelazzari.fr/test-adimeo/home](https://alexisdelazzari.fr/test-adimeo/home)

### Remarques

- **Problèmes avec le bundle Google :**
  Si vous rencontrez des problèmes avec le bundle Google, assurez-vous de configurer les redirections sur la console de développement Google, par exemple : `PATH-APP/php-test-apod/public/auth/google/check`.

- **Problèmes avec SSL :**
  Si vous rencontrez des problèmes avec SSL, voici une solution possible : [https://gist.github.com/nhatnx/7ac83423f7d4e51b713f4dfde03f38c5](https://gist.github.com/nhatnx/7ac83423f7d4e51b713f4dfde03f38c5)

- **Utilisation de l'ORM :**
  J'ai ajouté une fonctionnalité (possibilité de like les posts) mettant en valeur mes compétences avec un ORM. Bien que Symfony utilise Doctrine par défaut, j'ai utilisé mes compétences en ORM similaires à celles que j'utilise dans mon travail actuel avec TypeORM (Node.js).

### Remarque sur l'absence d'Ajax

Dans ce projet, je n'ai pas utilisé Ajax, donc chaque interaction sur le site recharge la page. Cela n'est pas optimal, mais le projet a été conçu pour tester mes compétences techniques en PHP avec Symfony.

## Petit plus

Afin de voir mes compétences sur un projet un peu plus conséquent, je vous invite à découvrir un projet que j'ai réalisé lors de ma formation à l'IUT de Metz, dans le cadre des cours dispensés par M. Pétré.

- **Repository Git :** [https://github.com/AlexisDelazzari/evalPHP.git](https://github.com/AlexisDelazzari/evalPHP.git)

- **Tester le projet :** [https://alexisdelazzari.fr/evalphp/home](https://alexisdelazzari.fr/evalphp/home)


# PHP Technical Test

## Instructions

The goal of this PHP test is to take you to space with the 
[picture of the day by the Nasa](https://apod.nasa.gov/apod/archivepixFull.html). We want to display a page on our 
website that will show us the current picture of the day (and its description). To achieve that, NASA gives us an 
API to fetch the data from their server. Unfortunately, This API has a limit on the number of calls we can make. So we 
will store the images on our side.

Here is an example of the response by the API :

```json
{
  "date": "2021-02-13",
  "explanation": "Get out your red/blue glasses and float next to asteroid 433 Eros. Orbiting the Sun once every 1.8 years, the near-Earth asteroid is named for the Greek god of love. Still, its shape more closely resembles a lumpy potato than a heart. Eros is a diminutive 40 x 14 x 14 kilometer world of undulating horizons, craters, boulders and valleys. Its unsettling scale and unromantic shape are emphasized in this mosaic of images from the NEAR Shoemaker spacecraft processed to yield a stereo anaglyphic view. Along with dramatic chiaroscuro, NEAR Shoemaker's 3-D imaging provided important measurements of the asteroid's landforms and structures, and clues to the origin of this city-sized chunk of Solar System. The smallest features visible here are about 30 meters across. Beginning on February 14, 2000, historic NEAR Shoemaker spent a year in orbit around Eros, the first spacecraft to orbit an asteroid. Twenty years ago, on February 12 2001, it landed on Eros, the first ever landing on an asteroid's surface. NEAR Shoemaker's final transmission from the surface of Eros was on February 28, 2001.",
  "hdurl": "https://apod.nasa.gov/apod/image/2102/PIA02471_800.jpg",
  "media_type": "image",
  "service_version": "v1",
  "title": "Stereo Eros",
  "url": "https://apod.nasa.gov/apod/image/2102/PIA02471_800.jpg"
}
```
For now, we only need these informations that will be displayed on our website, and thus will be saved on our database : 

- title ;
- explanation ;
- date ;
- image.

The application will only be accessible by logged in users. To achieve that, the login process will use Google as a login provider. 

Here are the steps you may want to follow to achieve this challenge :

- **Step 1**: make a CLI command that will be executed each day to fetch the picture of the day ;
- **Step 2**: make a page to display the picture of the day. If there is no picture (say the picture of the day is a video) we will display the picture of the previous day ;
- **Step 3**: protect our app, so the picture will only be visible by a logged in user. The user will be able to connect with a Google account using Google as login provider ;
- **Step 4**: make a small documentation explaining what you did, the technologies you used etc.

To fetch pictures from the NASA API, you need an API key. It will be sent to you by email.

When you finish this challenge, send a link to your repository by email. 

## Stack

The only constraint is to use PHP (use the version you want) and this Symfony project. You will then use any library you want, any database you want.

And most of all, have fun!