<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Exam\CoreBundle\Model;

/**
 * Interface to be implemented by exam manager. This adds an additional level
 * of abstraction between your application, and the actual repository.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
interface ExamManagerInterface
{
    /**
     * Creates an empty exam instance.
     *
     * @return ExamInterface
     */
    public function createExam();
}