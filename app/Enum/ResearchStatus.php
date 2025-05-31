<?php
namespace App\Enum;

enum ResearchStatus: string
{
    case Done = 'Done';
    case OnProcess = 'OnProcess';
    case Suspense = 'Suspense';
    case Failed = 'Failed';
    case Draft = 'Draft';
}