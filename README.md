# Shopping cart technical assessment test

This is a technical assessment test consisting of a shopping cart API written in PHP. This shop contains 7 books to buy.

## Requirements

- Add new products on shopping cart
- Update products on shopping cart
- Remove products on shopping cart
- Get total items from shopping cart

## Assessments

- Clean code
- Hexagonal architecture and DDD
- Testing
- Performance

## Resolution

You can see openapi documentation on file `./shopping-cart/etc/api-doc.yaml`.

To run the application execute `make up && make prepare`

To run tests execute `make test`

To run mutant testing execute `make mutant`

To check linter execute `make lint`

## Front app

The front app is in progress. I'm not a good designer :'(

## Pending tasks

- Create payment webhook: Remove cart after paid and update order status
- Create cronjob to remove old order pending to pay
- Create cronjob to remove old carts
- If localstorage cart_id not exist, get new empty cart
- Create notification microservice (golang or rust websockets) to communicate async actions
- Add asyncapi documentation
- Refactor front components and services for better reusable code
- Test front code
- Add cypress/playwright tests
- ¿cucumber tests on backend?
