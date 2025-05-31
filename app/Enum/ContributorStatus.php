<?php
namespace App\Enum;

enum ContributorStatus: string
{
    case Reuqest = 'Reuqest';
    case Reject = 'Reject';
    case Active = 'Active';
    case Inactive = 'Inactive';
}