<?php

namespace Repository;

use Core\DB\ModelRepository;

class SurveyRepository extends ModelRepository
{
    const SURVEY_ACTIVE = 0;
    const SURVEY_DRAFT = 1;
    const SURVEY_CLOSED = 2;

    public function findAllGroupedByStatus()
    {
        $surveys =  $this->getConnection()->query('SELECT * FROM Survey ORDER BY status');

        $groupedSurveys = array('active' => array(), 'drafts' => array(), 'closed' => array());
        return array_reduce($surveys, function($result, $item) {
            switch ($item['status']) {
                case self::SURVEY_ACTIVE:
                    $result['active'][] = $item;
                    break;

                case self::SURVEY_DRAFT:
                    $result['drafts'][] = $item;
                    break;

                case self::SURVEY_CLOSED:
                    $result['closed'][] = $item;
                    break;

                default:
                    break;
            }
            return $result;
        }, $groupedSurveys);

    }

    //TODO get rid of this
    public function replaceStatusColumn($surveyList)
    {
        return array_map(function($el) {
            switch (intval($el['status'])) {
                case self::SURVEY_ACTIVE:
                    $el['status'] = 'active';
                    break;

                case self::SURVEY_DRAFT:
                    $el['status'] = 'draft';
                    break;

                case self::SURVEY_CLOSED:
                    $el['status'] = 'closed';
                    break;

                default:
                    break;
            }

            return $el;
        }, $surveyList);

    }
}
