<?php
namespace App\Enum;

enum ContributorType: string
{
    case Origin = 'Origin';
    case Owner = 'Owner';
    case COOwner = 'COOwner';
    case Administrator = 'Administrator';
    case Contributor = 'Contributor';
}