<?php

namespace ShoppingCart\Order\Domain;

enum Status: string
{
    case PENDING_PAYMENT = 'pending_payment';
    case PAID = 'paid';
    case DELIVERY = 'delivery';
    case FINISHED = 'finished';
}