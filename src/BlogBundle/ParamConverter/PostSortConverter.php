<?php

declare(strict_types=1);

namespace BlogBundle\ParamConverter;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Temirkhan\Blog\Sort\Exception\InvalidArgumentException;
use Temirkhan\Blog\Sort\PostSort;

/**
 * Конвертер сортировки публикаций
 */
class PostSortConverter implements ParamConverterInterface
{
    /**
     * Сортировка по-умолчанию
     *
     * @var array
     */
    private $defaultSort;

    /**
     * Конструктор
     *
     * @param array $defaultSort
     */
    public function __construct(array $defaultSort)
    {
        $this->defaultSort = $defaultSort;
    }


    /**
     * Производит преобразование параметров
     *
     * @param Request $request
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $sort = $request->query->get('sort');

        if (!$sort || !is_array($sort)) {
            $sort = $this->defaultSort;
        }

        try {
            $postSort = new PostSort($sort);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException();
        }

        $request->attributes->set($configuration->getName(), $postSort);

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
        if ($configuration->getClass() === PostSort::class) {
            return true;
        }

        return false;
    }
}