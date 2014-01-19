<?php

namespace Repository;

use Core\DB\ModelRepository;

class QuestionRepository extends ModelRepository
{
    const QUESTION_REQUIRED = 1;
    const QUESTION_OPTIONAL = 0;

    const QUESTION_COUNT_SINGLE = 0;
    const QUESTION_COUNT_MULTIPLE = 1;
}
