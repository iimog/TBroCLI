<?php

namespace cli_db\propel\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use cli_db\propel\Cvterm;
use cli_db\propel\Studydesign;
use cli_db\propel\Studydesignprop;
use cli_db\propel\StudydesignpropPeer;
use cli_db\propel\StudydesignpropQuery;

/**
 * Base class that represents a query for the 'studydesignprop' table.
 *
 *
 *
 * @method StudydesignpropQuery orderByStudydesignpropId($order = Criteria::ASC) Order by the studydesignprop_id column
 * @method StudydesignpropQuery orderByStudydesignId($order = Criteria::ASC) Order by the studydesign_id column
 * @method StudydesignpropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method StudydesignpropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method StudydesignpropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method StudydesignpropQuery groupByStudydesignpropId() Group by the studydesignprop_id column
 * @method StudydesignpropQuery groupByStudydesignId() Group by the studydesign_id column
 * @method StudydesignpropQuery groupByTypeId() Group by the type_id column
 * @method StudydesignpropQuery groupByValue() Group by the value column
 * @method StudydesignpropQuery groupByRank() Group by the rank column
 *
 * @method StudydesignpropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method StudydesignpropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method StudydesignpropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method StudydesignpropQuery leftJoinStudydesign($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studydesign relation
 * @method StudydesignpropQuery rightJoinStudydesign($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studydesign relation
 * @method StudydesignpropQuery innerJoinStudydesign($relationAlias = null) Adds a INNER JOIN clause to the query using the Studydesign relation
 *
 * @method StudydesignpropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method StudydesignpropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method StudydesignpropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method Studydesignprop findOne(PropelPDO $con = null) Return the first Studydesignprop matching the query
 * @method Studydesignprop findOneOrCreate(PropelPDO $con = null) Return the first Studydesignprop matching the query, or a new Studydesignprop object populated from the query conditions when no match is found
 *
 * @method Studydesignprop findOneByStudydesignId(int $studydesign_id) Return the first Studydesignprop filtered by the studydesign_id column
 * @method Studydesignprop findOneByTypeId(int $type_id) Return the first Studydesignprop filtered by the type_id column
 * @method Studydesignprop findOneByValue(string $value) Return the first Studydesignprop filtered by the value column
 * @method Studydesignprop findOneByRank(int $rank) Return the first Studydesignprop filtered by the rank column
 *
 * @method array findByStudydesignpropId(int $studydesignprop_id) Return Studydesignprop objects filtered by the studydesignprop_id column
 * @method array findByStudydesignId(int $studydesign_id) Return Studydesignprop objects filtered by the studydesign_id column
 * @method array findByTypeId(int $type_id) Return Studydesignprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Studydesignprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Studydesignprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudydesignpropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseStudydesignpropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Studydesignprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new StudydesignpropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   StudydesignpropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return StudydesignpropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof StudydesignpropQuery) {
            return $criteria;
        }
        $query = new StudydesignpropQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Studydesignprop|Studydesignprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StudydesignpropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(StudydesignpropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Studydesignprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByStudydesignpropId($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Studydesignprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "studydesignprop_id", "studydesign_id", "type_id", "value", "rank" FROM "studydesignprop" WHERE "studydesignprop_id" = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Studydesignprop();
            $obj->hydrate($row);
            StudydesignpropPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Studydesignprop|Studydesignprop[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Studydesignprop[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return StudydesignpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StudydesignpropPeer::STUDYDESIGNPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return StudydesignpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StudydesignpropPeer::STUDYDESIGNPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the studydesignprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudydesignpropId(1234); // WHERE studydesignprop_id = 1234
     * $query->filterByStudydesignpropId(array(12, 34)); // WHERE studydesignprop_id IN (12, 34)
     * $query->filterByStudydesignpropId(array('min' => 12)); // WHERE studydesignprop_id >= 12
     * $query->filterByStudydesignpropId(array('max' => 12)); // WHERE studydesignprop_id <= 12
     * </code>
     *
     * @param     mixed $studydesignpropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudydesignpropQuery The current query, for fluid interface
     */
    public function filterByStudydesignpropId($studydesignpropId = null, $comparison = null)
    {
        if (is_array($studydesignpropId)) {
            $useMinMax = false;
            if (isset($studydesignpropId['min'])) {
                $this->addUsingAlias(StudydesignpropPeer::STUDYDESIGNPROP_ID, $studydesignpropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studydesignpropId['max'])) {
                $this->addUsingAlias(StudydesignpropPeer::STUDYDESIGNPROP_ID, $studydesignpropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudydesignpropPeer::STUDYDESIGNPROP_ID, $studydesignpropId, $comparison);
    }

    /**
     * Filter the query on the studydesign_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudydesignId(1234); // WHERE studydesign_id = 1234
     * $query->filterByStudydesignId(array(12, 34)); // WHERE studydesign_id IN (12, 34)
     * $query->filterByStudydesignId(array('min' => 12)); // WHERE studydesign_id >= 12
     * $query->filterByStudydesignId(array('max' => 12)); // WHERE studydesign_id <= 12
     * </code>
     *
     * @see       filterByStudydesign()
     *
     * @param     mixed $studydesignId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudydesignpropQuery The current query, for fluid interface
     */
    public function filterByStudydesignId($studydesignId = null, $comparison = null)
    {
        if (is_array($studydesignId)) {
            $useMinMax = false;
            if (isset($studydesignId['min'])) {
                $this->addUsingAlias(StudydesignpropPeer::STUDYDESIGN_ID, $studydesignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studydesignId['max'])) {
                $this->addUsingAlias(StudydesignpropPeer::STUDYDESIGN_ID, $studydesignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudydesignpropPeer::STUDYDESIGN_ID, $studydesignId, $comparison);
    }

    /**
     * Filter the query on the type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeId(1234); // WHERE type_id = 1234
     * $query->filterByTypeId(array(12, 34)); // WHERE type_id IN (12, 34)
     * $query->filterByTypeId(array('min' => 12)); // WHERE type_id >= 12
     * $query->filterByTypeId(array('max' => 12)); // WHERE type_id <= 12
     * </code>
     *
     * @see       filterByCvterm()
     *
     * @param     mixed $typeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudydesignpropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(StudydesignpropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(StudydesignpropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudydesignpropPeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudydesignpropQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StudydesignpropPeer::VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the rank column
     *
     * Example usage:
     * <code>
     * $query->filterByRank(1234); // WHERE rank = 1234
     * $query->filterByRank(array(12, 34)); // WHERE rank IN (12, 34)
     * $query->filterByRank(array('min' => 12)); // WHERE rank >= 12
     * $query->filterByRank(array('max' => 12)); // WHERE rank <= 12
     * </code>
     *
     * @param     mixed $rank The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudydesignpropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(StudydesignpropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(StudydesignpropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudydesignpropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Studydesign object
     *
     * @param   Studydesign|PropelObjectCollection $studydesign The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudydesignpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudydesign($studydesign, $comparison = null)
    {
        if ($studydesign instanceof Studydesign) {
            return $this
                ->addUsingAlias(StudydesignpropPeer::STUDYDESIGN_ID, $studydesign->getStudydesignId(), $comparison);
        } elseif ($studydesign instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudydesignpropPeer::STUDYDESIGN_ID, $studydesign->toKeyValue('PrimaryKey', 'StudydesignId'), $comparison);
        } else {
            throw new PropelException('filterByStudydesign() only accepts arguments of type Studydesign or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Studydesign relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudydesignpropQuery The current query, for fluid interface
     */
    public function joinStudydesign($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Studydesign');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Studydesign');
        }

        return $this;
    }

    /**
     * Use the Studydesign relation Studydesign object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudydesignQuery A secondary query class using the current class as primary query
     */
    public function useStudydesignQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudydesign($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Studydesign', '\cli_db\propel\StudydesignQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudydesignpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(StudydesignpropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudydesignpropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
        } else {
            throw new PropelException('filterByCvterm() only accepts arguments of type Cvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Cvterm relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudydesignpropQuery The current query, for fluid interface
     */
    public function joinCvterm($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Cvterm');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Cvterm');
        }

        return $this;
    }

    /**
     * Use the Cvterm relation Cvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermQuery A secondary query class using the current class as primary query
     */
    public function useCvtermQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvterm($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cvterm', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Studydesignprop $studydesignprop Object to remove from the list of results
     *
     * @return StudydesignpropQuery The current query, for fluid interface
     */
    public function prune($studydesignprop = null)
    {
        if ($studydesignprop) {
            $this->addUsingAlias(StudydesignpropPeer::STUDYDESIGNPROP_ID, $studydesignprop->getStudydesignpropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
