<?php

namespace Framework\Database;

use Exception;

abstract class BaseModel
{
    protected const ID = 'id';

    public function __construct(
        protected array $data = []
    ) {
    }

    /**
     * Create a new instance of the own class:
     * `return new self($data);`
     */
    abstract protected static function new(array $data = []): self;

    /**
     * Insert or update the model into the database.
     * If getId() === null, then insert else update.
     */
    abstract public function save(): self;

    /* Static functions */

    public static function all(): array
    {
        $dataSet = Database::unprepared('SELECT * FROM ' . self::getTableName());
        if ($dataSet === false) {
            return [];
        }
        
        $all = [];
        while ($row = $dataSet->fetch_assoc()) {
            array_push($all, static::new($row));
        }
        return $all;
    }

    public static function find(int $id): self
    {
        $dataSet = Database::prepared('SELECT * FROM ' . self::getTableName() . ' WHERE id = ?', 'i', $id);
        if ($dataSet === false) {
            return [];
        }

        /** @var \mysqli_result $result */
        if ($dataSet->num_rows !== 1) {
            return static::new();
        }

        return static::new($dataSet->fetch_assoc());
    }

    public static function delete(int $id): void
    {
        if (self::find($id)->getId() === null) {
            return;
        }

        Database::prepared('DELETE FROM ' . self::getTableName() . ' WHERE id=?', 'i', $id);
    }

    /* Getter */

    public function getId(): ?int
    {
        return $this->getDataIntOrNull(self::ID);
    }

    /* Magical getter and setter */

    public function __call(string $name, array $arguments): mixed
    {
        // e.g. get('lastname')
        if ($name === 'get') {
            if (count($arguments) !== 1) {
                throw new Exception('Getter function expects only one argument');
            }
            return $this->getData($arguments[0]);
        }

        // e.g. set('username', 'myusername')
        if ($name === 'set') {
            if (count($arguments) !== 2) {
                throw new Exception('Getter function expects two arguments');
            }
            return $this->setData($arguments[0], $arguments[1]);
        }

        // e.g. getLastname() or setUsername('myusername')
        if (!str_starts_with($name, 'get') && !str_starts_with($name, 'set')) {
            return null;
        }
        
        $prefix = substr($name, 0, 3);
        $property = lcfirst(str_replace($prefix, '', $name));
        
        if ($prefix === 'get') {
            return $this->getData($property);
        }

        if ($prefix === 'set') {
            if (count($arguments) !== 1) {
                throw new Exception('Setter functions expects only one argument');
            }
            return $this->setData($property, $arguments[0]);
        }
    }

    /* Getter & Setter - Bool */

    protected function getDataBoolOrNull(string $field): ?bool
    {
        return $this->getData($field) !== null ? $this->getDataBool($field) : null;
    }

    protected function getDataBool(string $field): bool
    {
        return (bool)$this->getData($field);
    }

    protected function setDataBoolOrNull(string $field, ?bool $value): self
    {
        if ($this->getDataBoolOrNull($field) === $value) {
            return $this;
        }
        return $this->setData($field, $value);
    }

    protected function setDataBool(string $field, bool $value): self
    {
        if ($this->getDataBool($field) === $value) {
            return $this;
        }
        return $this->setData($field, $value);
    }

    /* Getter & Setter - Float */

    protected function getDataFloatOrNull(string $field): ?float
    {
        return $this->getData($field) !== null ? $this->getDataFloat($field) : null;
    }

    protected function getDataFloat(string $field): float
    {
        return (float)$this->getData($field);
    }

    protected function setDataFloatOrNull(string $field, ?float $value): self
    {
        if ($this->getDataFloatOrNull($field) === $value) {
            return $this;
        }
        return $this->setData($field, $value);
    }

    protected function setDataFloat(string $field, float $value): self
    {
        if ($this->getDataFloat($field) === $value) {
            return $this;
        }
        return $this->setData($field, $value);
    }

    /* Getter & Setter - Integer */

    protected function getDataIntOrNull(string $field): ?int
    {
        return $this->getData($field) !== null ? $this->getDataInt($field) : null;
    }

    protected function getDataInt(string $field): int
    {
        return (int)$this->getData($field);
    }

    protected function setDataIntOrNull(string $field, ?int $value): self
    {
        if ($this->getDataIntOrNull($field) === $value) {
            return $this;
        }
        return $this->setData($field, $value);
    }

    protected function setDataInt(string $field, int $value): self
    {
        if ($this->getDataInt($field) === $value) {
            return $this;
        }
        return $this->setData($field, $value);
    }

    /* Getter & Setter - String */

    protected function getDataStringOrNull(string $field): ?string
    {
        return $this->getData($field) !== null ? $this->getDataString($field) : null;
    }

    protected function getDataString(string $field): string
    {
        return (string)$this->getData($field);
    }

    protected function setDataStringOrNull(string $field, ?string $value): self
    {
        if ($this->getDataStringOrNull($field) === $value) {
            return $this;
        }
        return $this->setData($field, $value);
    }

    protected function setDataString(string $field, string $value): self
    {
        if ($this->getDataString($field) === $value) {
            return $this;
        }
        return $this->setData($field, $value);
    }

    /* Helper functions */

    private function getData(string $field): mixed
    {
        if (!array_key_exists($field, $this->data)) {
            return null;
        }
        return $this->data[$field];
    }

    private function setData(string $field, mixed $value): self
    {
        $this->data[$field] = $value;
        return $this;
    }

    protected static function getTableName(): string
    {
        $classNameParts = explode('\\', get_called_class());
        $className = $classNameParts[count($classNameParts) - 1];
        $tableName = lcfirst($className) . 's';
        return $tableName;
    }
}

/*
<?php

namespace System\Modules\DataObjects;

abstract class AbstractModel implements IObject
{
    public function toArray(): array
    {
        $result = [];
        array_push($result, ...$this->data);
        return $result;
    }


}
 */