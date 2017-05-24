<?php

declare(strict_types = 1);

namespace Temirkhan\Blog\Manager;

/**
 * Интерфейс менеджера сущностей
 */
interface EntityManagerInterface
{
    /**
     * Сохраняет сущность
     *
     * @param $object
     */
    public function persist($object);


}
