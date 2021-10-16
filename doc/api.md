# API

---

## Cliente

### Criar

`POST /client/`

Contendo o seguinte corpo:

```
{
  "name": "Nome Client 1",
  "phone": "8812341234"
}
```

### Obter Lista

`GET /client/`

Com um retorno semelhante:

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

### Obter por ID

`GET /client/{uuid}/`

Com um retorno semelhante:

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

### Atualizar

`PATCH /client/{uuid}/`

Com o seguinte corpo:

```
{
    "name": "Elizangela",
    "phone": "88992417816"
}
```

Sem corpo na resposta.


### Excluir

`DELETE /client/{uuid}/`

Sem corpo na resposta.

---

## Pet

### Criar

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

### Obter Lista

`GET /pet/`

Com um retorno semelhante:

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

### Obter por ID

`GET /pet/{uuid}/`

Com um retorno semelhante:

```
{
  "status": true,
  "data": {
    "name": "Bob",
    "id": "fed2904b-6965-427f-834a-acc335df6547",
    "age": 5,
    "owner": {
      "name": "Elizangela",
      "phone": "88992417816",
      "id": "64ac0dd6-64f0-4709-9737-bf0e8fc7828c"
    },
    "species": "dog",
    "breed": "Pug"
  }
}
```

### Atualizar

`PATCH /pet/{uuid}/`

Contendo o seguinte corpo:

```
{
    "name": "Brutos",
    "age": 2,
    "ownerId": "64ac0dd6-64f0-4709-9737-bf0e8fc7828c",
    "species": "dog",
    "breed": "Pug"
}
```
Só é necessário enviar o que precisa ser alterado.

Sem corpo na resposta.

### Excluir

`DELETE /pet/{uuid}/`

Sem corpo no envio e na resposta.

---
