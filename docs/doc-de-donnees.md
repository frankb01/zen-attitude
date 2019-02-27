# Dico de données

## actualités : `News`

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, UNSIGNED, AUTO_INCREMENT, (NOT NULL, UNIQUE)
-|
|title|VARCHAR (64)|Not NULL| Titre de la news |
|content|TEXT|Not NULL| corps de la news |
|created_at|DATETIME|NOT NULL| date de création |

## Photos/Vidéos: `Media`

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, UNSIGNED, AUTO_INCREMENT, (NOT NULL, UNIQUE)
|-|
|url|VARCHAR( )|NOT NULL| Url ou chemin vers vidéos ou image  |
|alt|VARCHAR ( )| NOT NULL |champ “alt” de l’image|

## stage interne au club : `StageClub`

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, UNSIGNED, AUTO_INCREMENT, (NOT NULL, UNIQUE)|-|
|name|VARCHAR ( )|NOT NULL|nom du stage|
|place|VARCHAR ( )|NOT NULL|lieu du stage|
|date|DATETIME|NOT NULL|date du stage|
|poster|VARCHAR ( )|NULL|affiche du stage|

## user : `User` => avec annotation symfony `App_user`

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, UNSIGNED, AUTO_INCREMENT, (NOT NULL, UNIQUE)|-|
|name|VARCHAR ( )|NOT NULL|nom de l’utilisateur|
|firstname|VARCHAR ( )|NOT NULL|prénom de l’utilisateur|
|birthdate|DATETIME|NOT NULL|date de naissance|licen
|address|VARCHAR ( )|NOT NULL|adresse|
|phone|VARCHAR ( )|NOT NULL|numéro de tel|
|email|VARCHAR ( )|NOT NULL, UNIQUE|-|
|password|VARCHAR( )|NOT NULL, UNIQUE|-|
|license|VARCHAR ( )|NULL|numéro de license sportive|
|responsability|ENUM|NULL|role au sein du bureau|

## techniques : `Technique` 

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, UNSIGNED, AUTO_INCREMENT, (NOT NULL, UNIQUE)|-|
|title|VARCHAR ( )|NOT NULL|nom de la technique|
|attack|VARCHAR ( )|NOT NULL|type d’attaques|
|side|VARCHAR ( )|NOT NULL| intérieur (omote) ou exterieur (ura)|



## grade : `Grade` 

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, UNSIGNED, AUTO_INCREMENT, (NOT NULL, UNIQUE)|-|
|name|VARCHAR ( )|NOT NULL|nom du grade|


## rôle : `Role` 

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, UNSIGNED, AUTO_INCREMENT, (NOT NULL, UNIQUE)|-|
|role|VARCHAR ( )|NOT NULL|nom du role|
|code|VARCHAR ( )|NOT NULL| nom du role pour security.yaml|


## co-voiturage : `Carsharing` 

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, UNSIGNED, AUTO_INCREMENT, (NOT NULL, UNIQUE)|-|
|seat_number|TINY-INT|NOT NULL| nombre de sièges dispo|



## Stage de l’api : `Stage_api` 

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, UNSIGNED, AUTO_INCREMENT, (NOT NULL, UNIQUE)|-|
|id_api|INT|NOT NULL| identifiant  du stage sur l’api|
|is_suggested|INT|-|si conseillé par prof||




