<?php

namespace App\Imports;

use App\Imports\Dto\CoursData;
use Exception;
use Rap2hpoutre\FastExcel\FastExcel;

class CoursImport
{
    public function __construct(private readonly string $promotion_code)
    {
    }

    // build
    public static function build(string $promotion_code): self
    {
        return new self(promotion_code: $promotion_code);
    }

    // import

    /**
     * @throws Exception
     */
    public function import(string $file): void
    {
        (new FastExcel)->import($file, function ($line) {
            return CoursData::createFromArray(data: $line, promotion_code: $this->promotion_code);
        });
    }
}
