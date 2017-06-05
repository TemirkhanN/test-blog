<?php

declare(strict_types=1);

namespace BlogBundle\ParamConverter;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Temirkhan\Blog\Filter\PageFilter;

/**
 * Преобразование параметров запроса в постраничный фильтр
 */
class PageFilterConverter implements ParamConverterInterface
{
    /**
     * Производит преобразование
     *
     * @param Request $request
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        // TODO Уродливо. Переправить
        $page  = $request->attributes->get('page') ?: $request->query->get('page');
        $count = $request->query->get('count');

        if (!$page) {
            $page = 1;
        }

        if (!$count) {
            $count = 10;
        }

        $pageFilter = new PageFilter((int) $page, (int) $count);

        $request->attributes->set($configuration->getName(), $pageFilter);

        return true;
    }

    /**
     * Возвращает поддержку преобразования на основе переданной конфигурации
     *
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        if ($configuration->getClass() === PageFilter::class) {
            return true;
        }

        return false;
    }
}