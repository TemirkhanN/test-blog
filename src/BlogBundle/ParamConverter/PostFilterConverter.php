<?php

declare(strict_types=1);

namespace BlogBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Temirkhan\Blog\Filter\PostFilter;

/**
 * Конвертер фильтров публикаций
 */
class PostFilterConverter implements ParamConverterInterface
{
    /**
     * Производит преобразование параметров
     *
     * @param Request        $request
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $filter = $request->query->get('filter');

        if (!$filter) {
            $filter = [];
        }

        $postFilter = new PostFilter($filter);

        $request->attributes->set($configuration->getName(), $postFilter);

        return true;
    }

    /**
     * Возвращает поддержку конвертером указанной конфигурации
     *
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        if ($configuration->getClass() === PostFilter::class) {
            return true;
        }

        return false;
    }
}
