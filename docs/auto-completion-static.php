<?php

namespace Miaoxing\Config\Service;

class Config2
{
}

class ConfigModel
{
    /**
     * Set each attribute value, without checking whether the column is fillable, and save the model
     *
     * @param iterable $attributes
     * @return $this
     * @see ConfigModel::saveAttributes
     */
    public static function saveAttributes(iterable $attributes = []): self
    {
    }

    /**
     * Returns the record data as array
     *
     * @param array|callable $returnFields A indexed array specified the fields to return
     * @param callable|null $prepend
     * @return array
     * @see ConfigModel::toArray
     */
    public static function toArray($returnFields = [], callable $prepend = null): array
    {
    }

    /**
     * Returns the success result with model data
     *
     * @param array $merge
     * @return Ret
     * @see ConfigModel::toRet
     */
    public static function toRet(array $merge = []): \Wei\Ret
    {
    }

    /**
     * Return the record table name
     *
     * @return string
     * @see ConfigModel::getTable
     */
    public static function getTable(): string
    {
    }

    /**
     * Import a PHP array in this record
     *
     * @param iterable $array
     * @return $this
     * @see ConfigModel::fromArray
     */
    public static function fromArray(iterable $array): self
    {
    }

    /**
     * Save the record or data to database
     *
     * @param iterable $attributes
     * @return $this
     * @see ConfigModel::save
     */
    public static function save(iterable $attributes = []): self
    {
    }

    /**
     * Delete the current record and trigger the beforeDestroy and afterDestroy callback
     *
     * @param int|string $id
     * @return $this
     * @see ConfigModel::destroy
     */
    public static function destroy($id = null): self
    {
    }

    /**
     * Set the record field value
     *
     * @param string|int $name
     * @param mixed $value
     * @param bool $throwException
     * @return $this|false
     * @see ConfigModel::set
     */
    public static function set($name, $value, bool $throwException = true)
    {
    }

    /**
     * Executes the generated SQL and returns the found record object or false
     *
     * @param int|string|array|null $id
     * @return $this|null
     * @see ConfigModel::find
     */
    public static function find($id): ?self
    {
    }

    /**
     * Find a record by primary key, or throws 404 exception if record not found
     *
     * @param int|string $id
     * @return $this
     * @throws \Exception
     * @see ConfigModel::findOrFail
     */
    public static function findOrFail($id): self
    {
    }

    /**
     * Find a record by primary key, or init with the specified attributes if record not found
     *
     * @param int|string $id
     * @param array|object $attributes
     * @return $this
     * @see ConfigModel::findOrInit
     */
    public static function findOrInit($id = null, $attributes = []): self
    {
    }

    /**
     * Find a record by primary key, or save with the specified attributes if record not found
     *
     * @param int|string $id
     * @param array $attributes
     * @return $this
     * @see ConfigModel::findOrCreate
     */
    public static function findOrCreate($id, $attributes = []): self
    {
    }

    /**
     * @param array $attributes
     * @param array|object $data
     * @return $this
     * @see ConfigModel::findByOrCreate
     */
    public static function findByOrCreate($attributes, $data = []): self
    {
    }

    /**
     * Executes the generated SQL and returns the found record collection object or false
     *
     * @param array $ids
     * @return $this|$this[]
     * @see ConfigModel::findAll
     */
    public static function findAll(array $ids): self
    {
    }

    /**
     * @param mixed $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return $this|null
     * @see ConfigModel::findBy
     */
    public static function findBy($column, $operator = null, $value = null): ?self
    {
    }

    /**
     * @param mixed $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return $this|$this[]
     * @see ConfigModel::findAllBy
     */
    public static function findAllBy($column, $operator = null, $value = null): self
    {
    }

    /**
     * @param array $attributes
     * @param array|object $data
     * @return $this
     * @see ConfigModel::findOrInitBy
     */
    public static function findOrInitBy(array $attributes, $data = []): self
    {
    }

    /**
     * Find a record by primary key value and throws 404 exception if record not found
     *
     * @param mixed $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return $this
     * @throws \Exception
     * @see ConfigModel::findByOrFail
     */
    public static function findByOrFail($column, $operator = null, $value = null): self
    {
    }

    /**
     * @param Req|null $req
     * @return $this
     * @throws \Exception
     * @see ConfigModel::findFromReq
     */
    public static function findFromReq(\Wei\Req $req = null): self
    {
    }

    /**
     * Executes the generated SQL and returns the found record object or null if not found
     *
     * @return $this|null
     * @see ConfigModel::first
     */
    public static function first(): ?self
    {
    }

    /**
     * @return $this|$this[]
     * @see ConfigModel::all
     */
    public static function all(): self
    {
    }

    /**
     * Coll: Specifies a field to be the key of the fetched array
     *
     * @param string $column
     * @return $this
     * @see ConfigModel::indexBy
     */
    public static function indexBy(string $column): self
    {
    }

    /**
     * Returns the name of columns of current table
     *
     * @return array
     * @see ConfigModel::getColumns
     */
    public static function getColumns(): array
    {
    }

    /**
     * Check if column name exists
     *
     * @param string|int|null $name
     * @return bool
     * @see ConfigModel::hasColumn
     */
    public static function hasColumn($name): bool
    {
    }

    /**
     * Executes the generated query and returns the first array result
     *
     * @param mixed|null $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return array|null
     * @see ConfigModel::fetch
     */
    public static function fetch($column = null, $operator = null, $value = null): ?array
    {
    }

    /**
     * Executes the generated query and returns all array results
     *
     * @param mixed|null $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return array
     * @see ConfigModel::fetchAll
     */
    public static function fetchAll($column = null, $operator = null, $value = null): array
    {
    }

    /**
     * @param string $column
     * @param string|null $index
     * @return array
     * @see ConfigModel::pluck
     */
    public static function pluck(string $column, string $index = null): array
    {
    }

    /**
     * @param int $count
     * @param callable $callback
     * @return bool
     * @see ConfigModel::chunk
     */
    public static function chunk(int $count, callable $callback): bool
    {
    }

    /**
     * Executes a COUNT query to receive the rows number
     *
     * @param string $column
     * @return int
     * @see ConfigModel::cnt
     */
    public static function cnt($column = '*'): int
    {
    }

    /**
     * Execute a update query with specified data
     *
     * @param array|string $set
     * @param mixed $value
     * @return int
     * @see ConfigModel::update
     */
    public static function update($set = [], $value = null): int
    {
    }

    /**
     * Execute a delete query with specified conditions
     *
     * @param mixed|null $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return int
     * @see ConfigModel::delete
     */
    public static function delete($column = null, $operator = null, $value = null): int
    {
    }

    /**
     * Sets the position of the first result to retrieve (the "offset")
     *
     * @param int|float|string $offset The first result to return
     * @return $this
     * @see ConfigModel::offset
     */
    public static function offset($offset): self
    {
    }

    /**
     * Sets the maximum number of results to retrieve (the "limit")
     *
     * @param int|float|string $limit The maximum number of results to retrieve
     * @return $this
     * @see ConfigModel::limit
     */
    public static function limit($limit): self
    {
    }

    /**
     * Sets the page number, the "OFFSET" value is equals "($page - 1) * LIMIT"
     *
     * @param int $page The page number
     * @return $this
     * @see ConfigModel::page
     */
    public static function page($page): self
    {
    }

    /**
     * Specifies an item that is to be returned in the query result.
     * Replaces any previously specified selections, if any.
     *
     * @param array|string $columns the selection expressions
     * @return $this
     * @see ConfigModel::select
     */
    public static function select($columns = ['*']): self
    {
    }

    /**
     * @param array|string $columns
     * @return $this
     * @see ConfigModel::selectDistinct
     */
    public static function selectDistinct($columns): self
    {
    }

    /**
     * @param string $expression
     * @return $this
     * @see ConfigModel::selectRaw
     */
    public static function selectRaw($expression): self
    {
    }

    /**
     * Specifies columns that are not to be returned in the query result.
     * Replaces any previously specified selections, if any.
     *
     * @param array|string $columns
     * @return $this
     * @see ConfigModel::selectExcept
     */
    public static function selectExcept($columns): self
    {
    }

    /**
     * Specifies an item of the main table that is to be returned in the query result.
     * Default to all columns of the main table
     *
     * @param string $column
     * @return $this
     * @see ConfigModel::selectMain
     */
    public static function selectMain(string $column = '*'): self
    {
    }

    /**
     * Sets table for FROM query
     *
     * @param string $table
     * @param string|null $alias
     * @return $this
     * @see ConfigModel::from
     */
    public static function from(string $table, $alias = null): self
    {
    }

    /**
     * @param string $table
     * @param mixed|null $alias
     * @return $this
     * @see ConfigModel::table
     */
    public static function table(string $table, $alias = null): self
    {
    }

    /**
     * Adds a inner join to the query
     *
     * @param string $table The table name to join
     * @param string|null $first
     * @param string $operator
     * @param string|null $second
     * @param string $type
     * @return $this
     * @see ConfigModel::join
     */
    public static function join(string $table, string $first = null, string $operator = '=', string $second = null, string $type = 'INNER'): self
    {
    }

    /**
     * Adds a inner join to the query
     *
     * @param string $table The table name to join
     * @param string|null $first
     * @param string $operator
     * @param string|null $second
     * @return $this
     * @see ConfigModel::innerJoin
     */
    public static function innerJoin(string $table, string $first = null, string $operator = '=', string $second = null): self
    {
    }

    /**
     * Adds a left join to the query
     *
     * @param string $table The table name to join
     * @param string|null $first
     * @param string $operator
     * @param string|null $second
     * @return $this
     * @see ConfigModel::leftJoin
     */
    public static function leftJoin(string $table, string $first = null, string $operator = '=', string $second = null): self
    {
    }

    /**
     * Adds a right join to the query
     *
     * @param string $table The table name to join
     * @param string|null $first
     * @param string $operator
     * @param string|null $second
     * @return $this
     * @see ConfigModel::rightJoin
     */
    public static function rightJoin(string $table, string $first = null, string $operator = '=', string $second = null): self
    {
    }

    /**
     * Specifies one or more restrictions to the query result.
     * Replaces any previously specified restrictions, if any.
     *
     * ```php
     * $user = wei()->db('user')->where('id = 1');
     * $user = wei()->db('user')->where('id = ?', 1);
     * $users = wei()->db('user')->where(array('id' => '1', 'username' => 'twin'));
     * $users = wei()->where(array('id' => array('1', '2', '3')));
     * ```
     *
     * @param array|Closure|string|null $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::where
     */
    public static function where($column = null, $operator = null, $value = null): self
    {
    }

    /**
     * @param scalar $expression
     * @param mixed $params
     * @return $this
     * @see ConfigModel::whereRaw
     */
    public static function whereRaw($expression, $params = null): self
    {
    }

    /**
     * @param string $column
     * @param array $params
     * @return $this
     * @see ConfigModel::whereBetween
     */
    public static function whereBetween(string $column, array $params): self
    {
    }

    /**
     * @param string $column
     * @param array $params
     * @return $this
     * @see ConfigModel::whereNotBetween
     */
    public static function whereNotBetween(string $column, array $params): self
    {
    }

    /**
     * @param string $column
     * @param array $params
     * @return $this
     * @see ConfigModel::whereIn
     */
    public static function whereIn(string $column, array $params): self
    {
    }

    /**
     * @param string $column
     * @param array $params
     * @return $this
     * @see ConfigModel::whereNotIn
     */
    public static function whereNotIn(string $column, array $params): self
    {
    }

    /**
     * @param string $column
     * @return $this
     * @see ConfigModel::whereNull
     */
    public static function whereNull(string $column): self
    {
    }

    /**
     * @param string $column
     * @return $this
     * @see ConfigModel::whereNotNull
     */
    public static function whereNotNull(string $column): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrValue
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::whereDate
     */
    public static function whereDate(string $column, $opOrValue, $value = null): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrValue
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::whereMonth
     */
    public static function whereMonth(string $column, $opOrValue, $value = null): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrValue
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::whereDay
     */
    public static function whereDay(string $column, $opOrValue, $value = null): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrValue
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::whereYear
     */
    public static function whereYear(string $column, $opOrValue, $value = null): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrValue
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::whereTime
     */
    public static function whereTime(string $column, $opOrValue, $value = null): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrColumn2
     * @param mixed|null $column2
     * @return $this
     * @see ConfigModel::whereColumn
     */
    public static function whereColumn(string $column, $opOrColumn2, $column2 = null): self
    {
    }

    /**
     * 搜索字段是否包含某个值
     *
     * @param string $column
     * @param mixed $value
     * @param string $condition
     * @return $this
     * @see ConfigModel::whereContains
     */
    public static function whereContains(string $column, $value, string $condition = 'AND'): self
    {
    }

    /**
     * @param string $column
     * @param mixed $value
     * @param string $condition
     * @return $this
     * @see ConfigModel::whereNotContains
     */
    public static function whereNotContains(string $column, $value, string $condition = 'OR'): self
    {
    }

    /**
     * Search whether a column has a value other than the default value
     *
     * @param string $column
     * @param bool $has
     * @return $this
     * @see ConfigModel::whereHas
     */
    public static function whereHas(string $column, bool $has = true): self
    {
    }

    /**
     * Search whether a column dont have a value other than the default value
     *
     * @param string $column
     * @return $this
     * @see ConfigModel::whereNotHas
     */
    public static function whereNotHas(string $column): self
    {
    }

    /**
     * Specifies a grouping over the results of the query.
     * Replaces any previously specified groupings, if any.
     *
     * @param mixed $column the grouping column
     * @return $this
     * @see ConfigModel::groupBy
     */
    public static function groupBy($column): self
    {
    }

    /**
     * Specifies a restriction over the groups of the query.
     * Replaces any previous having restrictions, if any.
     *
     * @param mixed $column
     * @param mixed $operator
     * @param mixed|null $value
     * @param mixed $condition
     * @return $this
     * @see ConfigModel::having
     */
    public static function having($column, $operator, $value = null, $condition = 'AND'): self
    {
    }

    /**
     * Specifies an ordering for the query results.
     * Replaces any previously specified orderings, if any.
     *
     * @param string $column the ordering expression
     * @param string $order the ordering direction
     * @return $this
     * @see ConfigModel::orderBy
     */
    public static function orderBy(string $column, $order = 'ASC'): self
    {
    }

    /**
     * Adds a DESC ordering to the query
     *
     * @param string $field The name of field
     * @return $this
     * @see ConfigModel::desc
     */
    public static function desc(string $field): self
    {
    }

    /**
     * Add an ASC ordering to the query
     *
     * @param string $field The name of field
     * @return $this
     * @see ConfigModel::asc
     */
    public static function asc(string $field): self
    {
    }

    /**
     * @return $this
     * @see ConfigModel::forUpdate
     */
    public static function forUpdate(): self
    {
    }

    /**
     * @return $this
     * @see ConfigModel::forShare
     */
    public static function forShare(): self
    {
    }

    /**
     * @param string|bool $lock
     * @return $this
     * @see ConfigModel::lock
     */
    public static function lock($lock): self
    {
    }

    /**
     * @param mixed $value
     * @param callable $callback
     * @param callable|null $default
     * @return $this
     * @see ConfigModel::when
     */
    public static function when($value, callable $callback, callable $default = null): self
    {
    }

    /**
     * @param mixed $value
     * @param callable $callback
     * @param callable|null $default
     * @return $this
     * @see ConfigModel::unless
     */
    public static function unless($value, callable $callback, callable $default = null): self
    {
    }

    /**
     * @param callable|null $converter
     * @return $this
     * @see ConfigModel::setDbKeyConverter
     */
    public static function setDbKeyConverter(callable $converter = null): self
    {
    }

    /**
     * @param callable|null $converter
     * @return $this
     * @see ConfigModel::setPhpKeyConverter
     */
    public static function setPhpKeyConverter(callable $converter = null): self
    {
    }

    /**
     * Set or remove cache time for the query
     *
     * @param int|null $seconds
     * @return $this
     * @see ConfigModel::setCacheTime
     */
    public static function setCacheTime(?int $seconds): self
    {
    }

    /**
     * @param array|string|true $scopes
     * @return $this
     * @see ConfigModel::unscoped
     */
    public static function unscoped($scopes = []): self
    {
    }

    /**
     * Check if the model method defines the "Relation" attribute (or the "@Relation" tag in doc comment)
     *
     * This method only checks whether the specified method has the "Relation" attribute,
     * and does not check the actual logic.
     * It is provided for external use to avoid directly calling `$this->$relation()` to cause attacks.
     *
     * @param string $method
     * @return bool
     * @see ConfigModel::isRelation
     */
    public static function isRelation(string $method): bool
    {
    }

    /**
     * Really remove the record from database
     *
     * @param int|string $id
     * @return $this
     * @see ConfigModel::reallyDestroy
     */
    public static function reallyDestroy($id = false): self
    {
    }

    /**
     * Add a query to filter soft deleted records
     *
     * @return $this
     * @see ConfigModel::withoutDeleted
     */
    public static function withoutDeleted(): self
    {
    }

    /**
     * Add a query to return only deleted records
     *
     * @return $this
     * @see ConfigModel::onlyDeleted
     */
    public static function onlyDeleted(): self
    {
    }

    /**
     * Remove "withoutDeleted" in the query, expect to return all records
     *
     * @return $this
     * @see ConfigModel::withDeleted
     */
    public static function withDeleted(): self
    {
    }
}

namespace Miaoxing\Config\Service;

if (0) {
class Config2
{
}

class ConfigModel
{
    /**
     * Set each attribute value, without checking whether the column is fillable, and save the model
     *
     * @param iterable $attributes
     * @return $this
     * @see ConfigModel::saveAttributes
     */
    public function saveAttributes(iterable $attributes = []): self
    {
    }

    /**
     * Returns the record data as array
     *
     * @param array|callable $returnFields A indexed array specified the fields to return
     * @param callable|null $prepend
     * @return array
     * @see ConfigModel::toArray
     */
    public function toArray($returnFields = [], callable $prepend = null): array
    {
    }

    /**
     * Returns the success result with model data
     *
     * @param array $merge
     * @return Ret
     * @see ConfigModel::toRet
     */
    public function toRet(array $merge = []): \Wei\Ret
    {
    }

    /**
     * Return the record table name
     *
     * @return string
     * @see ConfigModel::getTable
     */
    public function getTable(): string
    {
    }

    /**
     * Import a PHP array in this record
     *
     * @param iterable $array
     * @return $this
     * @see ConfigModel::fromArray
     */
    public function fromArray(iterable $array): self
    {
    }

    /**
     * Save the record or data to database
     *
     * @param iterable $attributes
     * @return $this
     * @see ConfigModel::save
     */
    public function save(iterable $attributes = []): self
    {
    }

    /**
     * Delete the current record and trigger the beforeDestroy and afterDestroy callback
     *
     * @param int|string $id
     * @return $this
     * @see ConfigModel::destroy
     */
    public function destroy($id = null): self
    {
    }

    /**
     * Set the record field value
     *
     * @param string|int $name
     * @param mixed $value
     * @param bool $throwException
     * @return $this|false
     * @see ConfigModel::set
     */
    public function set($name, $value, bool $throwException = true)
    {
    }

    /**
     * Executes the generated SQL and returns the found record object or false
     *
     * @param int|string|array|null $id
     * @return $this|null
     * @see ConfigModel::find
     */
    public function find($id): ?self
    {
    }

    /**
     * Find a record by primary key, or throws 404 exception if record not found
     *
     * @param int|string $id
     * @return $this
     * @throws \Exception
     * @see ConfigModel::findOrFail
     */
    public function findOrFail($id): self
    {
    }

    /**
     * Find a record by primary key, or init with the specified attributes if record not found
     *
     * @param int|string $id
     * @param array|object $attributes
     * @return $this
     * @see ConfigModel::findOrInit
     */
    public function findOrInit($id = null, $attributes = []): self
    {
    }

    /**
     * Find a record by primary key, or save with the specified attributes if record not found
     *
     * @param int|string $id
     * @param array $attributes
     * @return $this
     * @see ConfigModel::findOrCreate
     */
    public function findOrCreate($id, $attributes = []): self
    {
    }

    /**
     * @param array $attributes
     * @param array|object $data
     * @return $this
     * @see ConfigModel::findByOrCreate
     */
    public function findByOrCreate($attributes, $data = []): self
    {
    }

    /**
     * Executes the generated SQL and returns the found record collection object or false
     *
     * @param array $ids
     * @return $this|$this[]
     * @see ConfigModel::findAll
     */
    public function findAll(array $ids): self
    {
    }

    /**
     * @param mixed $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return $this|null
     * @see ConfigModel::findBy
     */
    public function findBy($column, $operator = null, $value = null): ?self
    {
    }

    /**
     * @param mixed $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return $this|$this[]
     * @see ConfigModel::findAllBy
     */
    public function findAllBy($column, $operator = null, $value = null): self
    {
    }

    /**
     * @param array $attributes
     * @param array|object $data
     * @return $this
     * @see ConfigModel::findOrInitBy
     */
    public function findOrInitBy(array $attributes, $data = []): self
    {
    }

    /**
     * Find a record by primary key value and throws 404 exception if record not found
     *
     * @param mixed $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return $this
     * @throws \Exception
     * @see ConfigModel::findByOrFail
     */
    public function findByOrFail($column, $operator = null, $value = null): self
    {
    }

    /**
     * @param Req|null $req
     * @return $this
     * @throws \Exception
     * @see ConfigModel::findFromReq
     */
    public function findFromReq(\Wei\Req $req = null): self
    {
    }

    /**
     * Executes the generated SQL and returns the found record object or null if not found
     *
     * @return $this|null
     * @see ConfigModel::first
     */
    public function first(): ?self
    {
    }

    /**
     * @return $this|$this[]
     * @see ConfigModel::all
     */
    public function all(): self
    {
    }

    /**
     * Coll: Specifies a field to be the key of the fetched array
     *
     * @param string $column
     * @return $this
     * @see ConfigModel::indexBy
     */
    public function indexBy(string $column): self
    {
    }

    /**
     * Returns the name of columns of current table
     *
     * @return array
     * @see ConfigModel::getColumns
     */
    public function getColumns(): array
    {
    }

    /**
     * Check if column name exists
     *
     * @param string|int|null $name
     * @return bool
     * @see ConfigModel::hasColumn
     */
    public function hasColumn($name): bool
    {
    }

    /**
     * Executes the generated query and returns the first array result
     *
     * @param mixed|null $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return array|null
     * @see ConfigModel::fetch
     */
    public function fetch($column = null, $operator = null, $value = null): ?array
    {
    }

    /**
     * Executes the generated query and returns all array results
     *
     * @param mixed|null $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return array
     * @see ConfigModel::fetchAll
     */
    public function fetchAll($column = null, $operator = null, $value = null): array
    {
    }

    /**
     * @param string $column
     * @param string|null $index
     * @return array
     * @see ConfigModel::pluck
     */
    public function pluck(string $column, string $index = null): array
    {
    }

    /**
     * @param int $count
     * @param callable $callback
     * @return bool
     * @see ConfigModel::chunk
     */
    public function chunk(int $count, callable $callback): bool
    {
    }

    /**
     * Executes a COUNT query to receive the rows number
     *
     * @param string $column
     * @return int
     * @see ConfigModel::cnt
     */
    public function cnt($column = '*'): int
    {
    }

    /**
     * Execute a update query with specified data
     *
     * @param array|string $set
     * @param mixed $value
     * @return int
     * @see ConfigModel::update
     */
    public function update($set = [], $value = null): int
    {
    }

    /**
     * Execute a delete query with specified conditions
     *
     * @param mixed|null $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return int
     * @see ConfigModel::delete
     */
    public function delete($column = null, $operator = null, $value = null): int
    {
    }

    /**
     * Sets the position of the first result to retrieve (the "offset")
     *
     * @param int|float|string $offset The first result to return
     * @return $this
     * @see ConfigModel::offset
     */
    public function offset($offset): self
    {
    }

    /**
     * Sets the maximum number of results to retrieve (the "limit")
     *
     * @param int|float|string $limit The maximum number of results to retrieve
     * @return $this
     * @see ConfigModel::limit
     */
    public function limit($limit): self
    {
    }

    /**
     * Sets the page number, the "OFFSET" value is equals "($page - 1) * LIMIT"
     *
     * @param int $page The page number
     * @return $this
     * @see ConfigModel::page
     */
    public function page($page): self
    {
    }

    /**
     * Specifies an item that is to be returned in the query result.
     * Replaces any previously specified selections, if any.
     *
     * @param array|string $columns the selection expressions
     * @return $this
     * @see ConfigModel::select
     */
    public function select($columns = ['*']): self
    {
    }

    /**
     * @param array|string $columns
     * @return $this
     * @see ConfigModel::selectDistinct
     */
    public function selectDistinct($columns): self
    {
    }

    /**
     * @param string $expression
     * @return $this
     * @see ConfigModel::selectRaw
     */
    public function selectRaw($expression): self
    {
    }

    /**
     * Specifies columns that are not to be returned in the query result.
     * Replaces any previously specified selections, if any.
     *
     * @param array|string $columns
     * @return $this
     * @see ConfigModel::selectExcept
     */
    public function selectExcept($columns): self
    {
    }

    /**
     * Specifies an item of the main table that is to be returned in the query result.
     * Default to all columns of the main table
     *
     * @param string $column
     * @return $this
     * @see ConfigModel::selectMain
     */
    public function selectMain(string $column = '*'): self
    {
    }

    /**
     * Sets table for FROM query
     *
     * @param string $table
     * @param string|null $alias
     * @return $this
     * @see ConfigModel::from
     */
    public function from(string $table, $alias = null): self
    {
    }

    /**
     * @param string $table
     * @param mixed|null $alias
     * @return $this
     * @see ConfigModel::table
     */
    public function table(string $table, $alias = null): self
    {
    }

    /**
     * Adds a inner join to the query
     *
     * @param string $table The table name to join
     * @param string|null $first
     * @param string $operator
     * @param string|null $second
     * @param string $type
     * @return $this
     * @see ConfigModel::join
     */
    public function join(string $table, string $first = null, string $operator = '=', string $second = null, string $type = 'INNER'): self
    {
    }

    /**
     * Adds a inner join to the query
     *
     * @param string $table The table name to join
     * @param string|null $first
     * @param string $operator
     * @param string|null $second
     * @return $this
     * @see ConfigModel::innerJoin
     */
    public function innerJoin(string $table, string $first = null, string $operator = '=', string $second = null): self
    {
    }

    /**
     * Adds a left join to the query
     *
     * @param string $table The table name to join
     * @param string|null $first
     * @param string $operator
     * @param string|null $second
     * @return $this
     * @see ConfigModel::leftJoin
     */
    public function leftJoin(string $table, string $first = null, string $operator = '=', string $second = null): self
    {
    }

    /**
     * Adds a right join to the query
     *
     * @param string $table The table name to join
     * @param string|null $first
     * @param string $operator
     * @param string|null $second
     * @return $this
     * @see ConfigModel::rightJoin
     */
    public function rightJoin(string $table, string $first = null, string $operator = '=', string $second = null): self
    {
    }

    /**
     * Specifies one or more restrictions to the query result.
     * Replaces any previously specified restrictions, if any.
     *
     * ```php
     * $user = wei()->db('user')->where('id = 1');
     * $user = wei()->db('user')->where('id = ?', 1);
     * $users = wei()->db('user')->where(array('id' => '1', 'username' => 'twin'));
     * $users = wei()->where(array('id' => array('1', '2', '3')));
     * ```
     *
     * @param array|Closure|string|null $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::where
     */
    public function where($column = null, $operator = null, $value = null): self
    {
    }

    /**
     * @param scalar $expression
     * @param mixed $params
     * @return $this
     * @see ConfigModel::whereRaw
     */
    public function whereRaw($expression, $params = null): self
    {
    }

    /**
     * @param string $column
     * @param array $params
     * @return $this
     * @see ConfigModel::whereBetween
     */
    public function whereBetween(string $column, array $params): self
    {
    }

    /**
     * @param string $column
     * @param array $params
     * @return $this
     * @see ConfigModel::whereNotBetween
     */
    public function whereNotBetween(string $column, array $params): self
    {
    }

    /**
     * @param string $column
     * @param array $params
     * @return $this
     * @see ConfigModel::whereIn
     */
    public function whereIn(string $column, array $params): self
    {
    }

    /**
     * @param string $column
     * @param array $params
     * @return $this
     * @see ConfigModel::whereNotIn
     */
    public function whereNotIn(string $column, array $params): self
    {
    }

    /**
     * @param string $column
     * @return $this
     * @see ConfigModel::whereNull
     */
    public function whereNull(string $column): self
    {
    }

    /**
     * @param string $column
     * @return $this
     * @see ConfigModel::whereNotNull
     */
    public function whereNotNull(string $column): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrValue
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::whereDate
     */
    public function whereDate(string $column, $opOrValue, $value = null): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrValue
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::whereMonth
     */
    public function whereMonth(string $column, $opOrValue, $value = null): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrValue
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::whereDay
     */
    public function whereDay(string $column, $opOrValue, $value = null): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrValue
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::whereYear
     */
    public function whereYear(string $column, $opOrValue, $value = null): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrValue
     * @param mixed|null $value
     * @return $this
     * @see ConfigModel::whereTime
     */
    public function whereTime(string $column, $opOrValue, $value = null): self
    {
    }

    /**
     * @param string $column
     * @param mixed $opOrColumn2
     * @param mixed|null $column2
     * @return $this
     * @see ConfigModel::whereColumn
     */
    public function whereColumn(string $column, $opOrColumn2, $column2 = null): self
    {
    }

    /**
     * 搜索字段是否包含某个值
     *
     * @param string $column
     * @param mixed $value
     * @param string $condition
     * @return $this
     * @see ConfigModel::whereContains
     */
    public function whereContains(string $column, $value, string $condition = 'AND'): self
    {
    }

    /**
     * @param string $column
     * @param mixed $value
     * @param string $condition
     * @return $this
     * @see ConfigModel::whereNotContains
     */
    public function whereNotContains(string $column, $value, string $condition = 'OR'): self
    {
    }

    /**
     * Search whether a column has a value other than the default value
     *
     * @param string $column
     * @param bool $has
     * @return $this
     * @see ConfigModel::whereHas
     */
    public function whereHas(string $column, bool $has = true): self
    {
    }

    /**
     * Search whether a column dont have a value other than the default value
     *
     * @param string $column
     * @return $this
     * @see ConfigModel::whereNotHas
     */
    public function whereNotHas(string $column): self
    {
    }

    /**
     * Specifies a grouping over the results of the query.
     * Replaces any previously specified groupings, if any.
     *
     * @param mixed $column the grouping column
     * @return $this
     * @see ConfigModel::groupBy
     */
    public function groupBy($column): self
    {
    }

    /**
     * Specifies a restriction over the groups of the query.
     * Replaces any previous having restrictions, if any.
     *
     * @param mixed $column
     * @param mixed $operator
     * @param mixed|null $value
     * @param mixed $condition
     * @return $this
     * @see ConfigModel::having
     */
    public function having($column, $operator, $value = null, $condition = 'AND'): self
    {
    }

    /**
     * Specifies an ordering for the query results.
     * Replaces any previously specified orderings, if any.
     *
     * @param string $column the ordering expression
     * @param string $order the ordering direction
     * @return $this
     * @see ConfigModel::orderBy
     */
    public function orderBy(string $column, $order = 'ASC'): self
    {
    }

    /**
     * Adds a DESC ordering to the query
     *
     * @param string $field The name of field
     * @return $this
     * @see ConfigModel::desc
     */
    public function desc(string $field): self
    {
    }

    /**
     * Add an ASC ordering to the query
     *
     * @param string $field The name of field
     * @return $this
     * @see ConfigModel::asc
     */
    public function asc(string $field): self
    {
    }

    /**
     * @return $this
     * @see ConfigModel::forUpdate
     */
    public function forUpdate(): self
    {
    }

    /**
     * @return $this
     * @see ConfigModel::forShare
     */
    public function forShare(): self
    {
    }

    /**
     * @param string|bool $lock
     * @return $this
     * @see ConfigModel::lock
     */
    public function lock($lock): self
    {
    }

    /**
     * @param mixed $value
     * @param callable $callback
     * @param callable|null $default
     * @return $this
     * @see ConfigModel::when
     */
    public function when($value, callable $callback, callable $default = null): self
    {
    }

    /**
     * @param mixed $value
     * @param callable $callback
     * @param callable|null $default
     * @return $this
     * @see ConfigModel::unless
     */
    public function unless($value, callable $callback, callable $default = null): self
    {
    }

    /**
     * @param callable|null $converter
     * @return $this
     * @see ConfigModel::setDbKeyConverter
     */
    public function setDbKeyConverter(callable $converter = null): self
    {
    }

    /**
     * @param callable|null $converter
     * @return $this
     * @see ConfigModel::setPhpKeyConverter
     */
    public function setPhpKeyConverter(callable $converter = null): self
    {
    }

    /**
     * Set or remove cache time for the query
     *
     * @param int|null $seconds
     * @return $this
     * @see ConfigModel::setCacheTime
     */
    public function setCacheTime(?int $seconds): self
    {
    }

    /**
     * @param array|string|true $scopes
     * @return $this
     * @see ConfigModel::unscoped
     */
    public function unscoped($scopes = []): self
    {
    }

    /**
     * Check if the model method defines the "Relation" attribute (or the "@Relation" tag in doc comment)
     *
     * This method only checks whether the specified method has the "Relation" attribute,
     * and does not check the actual logic.
     * It is provided for external use to avoid directly calling `$this->$relation()` to cause attacks.
     *
     * @param string $method
     * @return bool
     * @see ConfigModel::isRelation
     */
    public function isRelation(string $method): bool
    {
    }

    /**
     * Really remove the record from database
     *
     * @param int|string $id
     * @return $this
     * @see ConfigModel::reallyDestroy
     */
    public function reallyDestroy($id = false): self
    {
    }

    /**
     * Add a query to filter soft deleted records
     *
     * @return $this
     * @see ConfigModel::withoutDeleted
     */
    public function withoutDeleted(): self
    {
    }

    /**
     * Add a query to return only deleted records
     *
     * @return $this
     * @see ConfigModel::onlyDeleted
     */
    public function onlyDeleted(): self
    {
    }

    /**
     * Remove "withoutDeleted" in the query, expect to return all records
     *
     * @return $this
     * @see ConfigModel::withDeleted
     */
    public function withDeleted(): self
    {
    }
}
}
