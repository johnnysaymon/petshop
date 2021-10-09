# API

## Criar Client

`POST /client/`

Contendo o seguinte corpo:

```
{
  "name": "Nome Client 1",
  "phone": "8812341234"
}
```

## Obter Client

`GET /client/`

Com um retorno semelhante a esse:

```
{
  "status": true,
  "data": [
    {
      "name": "Nome Client 1",
      "phone": "8812341234",
      "id": "48da9eb2-b416-4663-bd3d-33fd6f34c0af"
    },
    {
      "name": "Nome Client 2",
      "phone": "8812341234",
      "id": "48da9eb2-b416-4663-bd3d-33fd6f34c0af"
    }
  ]
}
```

## Obter Cliente por ID

`GET /client/{uuid}/`

Com um retorno semelhante a esse:

```
{
  "status": true,
  "data": [
    {
      "name": "Nome do Client",
      "phone": "8812341234",
      "id": "48da9eb2-b416-4663-bd3d-33fd6f34c0af"
    }
  ]
}
```

## Criar Pet

`POST /pet/`

Contendo o seguinte corpo:

```
{
	"species": "cat",
	"breedName": "Persa",
	"name": "Didi",
	"age": 2,
	"ownerId": "2f60b027-64b8-4d0a-a22e-a0404e14f294"
}
```

## Obter Pets

`GET /pet/`

Com um retorno semelhante a esse:

```
{
  "status": true,
  "data": [
    {
      "name": "Didi",
      "id": "0b73f8b3-d328-473a-80a9-15aa149ef8c9",
      "age": 2,
      "owner": {
        "name": "Maria",
        "phone": "8835223322",
        "id": "2f60b027-64b8-4d0a-a22e-a0404e14f294"
      },
      "species": "cat",
      "breed": "Persa"
    },
    {
      "name": "Apolo",
      "id": "70e9adb5-46a8-4875-9d10-3fe3174dc2f4",
      "age": 5,
      "owner": {
        "name": "Maria",
        "phone": "8835223322",
        "id": "2f60b027-64b8-4d0a-a22e-a0404e14f294"
      },
      "species": "dog",
      "breed": "Labrador"
    }
  ]
}
```
