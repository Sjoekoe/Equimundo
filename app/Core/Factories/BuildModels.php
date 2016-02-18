<?php
namespace EQM\Core\Factories;

trait BuildModels
{
    /**
     * @var \EQM\Core\Factories\ModelFactory
     */
    protected $modelFactory;

    /**
     * @param string $model
     * @param array $attributes
     * @return object
     */
    public function make($model, array $attributes = [])
    {
        return $this->modelFactory->make($model, $attributes);
    }

    /**
     * @param string $model
     * @param array $attributes
     * @param int $times
     * @return object
     */
    public function create($model, array $attributes = [], $times = 1)
    {
        return $this->modelFactory->create($model, $attributes, $times);
    }
}
