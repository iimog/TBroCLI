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
use cli_db\propel\FeatureRelationship;
use cli_db\propel\FeatureRelationshipprop;
use cli_db\propel\FeatureRelationshippropPeer;
use cli_db\propel\FeatureRelationshippropPub;
use cli_db\propel\FeatureRelationshippropQuery;

/**
 * Base class that represents a query for the 'feature_relationshipprop' table.
 *
 *
 *
 * @method FeatureRelationshippropQuery orderByFeatureRelationshippropId($order = Criteria::ASC) Order by the feature_relationshipprop_id column
 * @method FeatureRelationshippropQuery orderByFeatureRelationshipId($order = Criteria::ASC) Order by the feature_relationship_id column
 * @method FeatureRelationshippropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method FeatureRelationshippropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method FeatureRelationshippropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method FeatureRelationshippropQuery groupByFeatureRelationshippropId() Group by the feature_relationshipprop_id column
 * @method FeatureRelationshippropQuery groupByFeatureRelationshipId() Group by the feature_relationship_id column
 * @method FeatureRelationshippropQuery groupByTypeId() Group by the type_id column
 * @method FeatureRelationshippropQuery groupByValue() Group by the value column
 * @method FeatureRelationshippropQuery groupByRank() Group by the rank column
 *
 * @method FeatureRelationshippropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeatureRelationshippropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeatureRelationshippropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeatureRelationshippropQuery leftJoinFeatureRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureRelationship relation
 * @method FeatureRelationshippropQuery rightJoinFeatureRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureRelationship relation
 * @method FeatureRelationshippropQuery innerJoinFeatureRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureRelationship relation
 *
 * @method FeatureRelationshippropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method FeatureRelationshippropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method FeatureRelationshippropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method FeatureRelationshippropQuery leftJoinFeatureRelationshippropPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureRelationshippropPub relation
 * @method FeatureRelationshippropQuery rightJoinFeatureRelationshippropPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureRelationshippropPub relation
 * @method FeatureRelationshippropQuery innerJoinFeatureRelationshippropPub($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureRelationshippropPub relation
 *
 * @method FeatureRelationshipprop findOne(PropelPDO $con = null) Return the first FeatureRelationshipprop matching the query
 * @method FeatureRelationshipprop findOneOrCreate(PropelPDO $con = null) Return the first FeatureRelationshipprop matching the query, or a new FeatureRelationshipprop object populated from the query conditions when no match is found
 *
 * @method FeatureRelationshipprop findOneByFeatureRelationshipId(int $feature_relationship_id) Return the first FeatureRelationshipprop filtered by the feature_relationship_id column
 * @method FeatureRelationshipprop findOneByTypeId(int $type_id) Return the first FeatureRelationshipprop filtered by the type_id column
 * @method FeatureRelationshipprop findOneByValue(string $value) Return the first FeatureRelationshipprop filtered by the value column
 * @method FeatureRelationshipprop findOneByRank(int $rank) Return the first FeatureRelationshipprop filtered by the rank column
 *
 * @method array findByFeatureRelationshippropId(int $feature_relationshipprop_id) Return FeatureRelationshipprop objects filtered by the feature_relationshipprop_id column
 * @method array findByFeatureRelationshipId(int $feature_relationship_id) Return FeatureRelationshipprop objects filtered by the feature_relationship_id column
 * @method array findByTypeId(int $type_id) Return FeatureRelationshipprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return FeatureRelationshipprop objects filtered by the value column
 * @method array findByRank(int $rank) Return FeatureRelationshipprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureRelationshippropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeatureRelationshippropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\FeatureRelationshipprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeatureRelationshippropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeatureRelationshippropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeatureRelationshippropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeatureRelationshippropQuery) {
            return $criteria;
        }
        $query = new FeatureRelationshippropQuery();
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
     * @return   FeatureRelationshipprop|FeatureRelationshipprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeatureRelationshippropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeatureRelationshippropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FeatureRelationshipprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeatureRelationshippropId($key, $con = null)
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
     * @return                 FeatureRelationshipprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "feature_relationshipprop_id", "feature_relationship_id", "type_id", "value", "rank" FROM "feature_relationshipprop" WHERE "feature_relationshipprop_id" = :p0';
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
            $obj = new FeatureRelationshipprop();
            $obj->hydrate($row);
            FeatureRelationshippropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return FeatureRelationshipprop|FeatureRelationshipprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FeatureRelationshipprop[]|mixed the list of results, formatted by the current formatter
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
     * @return FeatureRelationshippropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIPPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeatureRelationshippropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIPPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the feature_relationshipprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureRelationshippropId(1234); // WHERE feature_relationshipprop_id = 1234
     * $query->filterByFeatureRelationshippropId(array(12, 34)); // WHERE feature_relationshipprop_id IN (12, 34)
     * $query->filterByFeatureRelationshippropId(array('min' => 12)); // WHERE feature_relationshipprop_id >= 12
     * $query->filterByFeatureRelationshippropId(array('max' => 12)); // WHERE feature_relationshipprop_id <= 12
     * </code>
     *
     * @param     mixed $featureRelationshippropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureRelationshippropQuery The current query, for fluid interface
     */
    public function filterByFeatureRelationshippropId($featureRelationshippropId = null, $comparison = null)
    {
        if (is_array($featureRelationshippropId)) {
            $useMinMax = false;
            if (isset($featureRelationshippropId['min'])) {
                $this->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIPPROP_ID, $featureRelationshippropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureRelationshippropId['max'])) {
                $this->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIPPROP_ID, $featureRelationshippropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIPPROP_ID, $featureRelationshippropId, $comparison);
    }

    /**
     * Filter the query on the feature_relationship_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureRelationshipId(1234); // WHERE feature_relationship_id = 1234
     * $query->filterByFeatureRelationshipId(array(12, 34)); // WHERE feature_relationship_id IN (12, 34)
     * $query->filterByFeatureRelationshipId(array('min' => 12)); // WHERE feature_relationship_id >= 12
     * $query->filterByFeatureRelationshipId(array('max' => 12)); // WHERE feature_relationship_id <= 12
     * </code>
     *
     * @see       filterByFeatureRelationship()
     *
     * @param     mixed $featureRelationshipId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureRelationshippropQuery The current query, for fluid interface
     */
    public function filterByFeatureRelationshipId($featureRelationshipId = null, $comparison = null)
    {
        if (is_array($featureRelationshipId)) {
            $useMinMax = false;
            if (isset($featureRelationshipId['min'])) {
                $this->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIP_ID, $featureRelationshipId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureRelationshipId['max'])) {
                $this->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIP_ID, $featureRelationshipId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIP_ID, $featureRelationshipId, $comparison);
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
     * @return FeatureRelationshippropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(FeatureRelationshippropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(FeatureRelationshippropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshippropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return FeatureRelationshippropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FeatureRelationshippropPeer::VALUE, $value, $comparison);
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
     * @return FeatureRelationshippropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(FeatureRelationshippropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(FeatureRelationshippropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshippropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related FeatureRelationship object
     *
     * @param   FeatureRelationship|PropelObjectCollection $featureRelationship The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureRelationshippropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureRelationship($featureRelationship, $comparison = null)
    {
        if ($featureRelationship instanceof FeatureRelationship) {
            return $this
                ->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIP_ID, $featureRelationship->getFeatureRelationshipId(), $comparison);
        } elseif ($featureRelationship instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIP_ID, $featureRelationship->toKeyValue('PrimaryKey', 'FeatureRelationshipId'), $comparison);
        } else {
            throw new PropelException('filterByFeatureRelationship() only accepts arguments of type FeatureRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureRelationshippropQuery The current query, for fluid interface
     */
    public function joinFeatureRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureRelationship');

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
            $this->addJoinObject($join, 'FeatureRelationship');
        }

        return $this;
    }

    /**
     * Use the FeatureRelationship relation FeatureRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useFeatureRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureRelationship', '\cli_db\propel\FeatureRelationshipQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureRelationshippropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(FeatureRelationshippropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureRelationshippropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return FeatureRelationshippropQuery The current query, for fluid interface
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
     * Filter the query by a related FeatureRelationshippropPub object
     *
     * @param   FeatureRelationshippropPub|PropelObjectCollection $featureRelationshippropPub  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureRelationshippropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureRelationshippropPub($featureRelationshippropPub, $comparison = null)
    {
        if ($featureRelationshippropPub instanceof FeatureRelationshippropPub) {
            return $this
                ->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIPPROP_ID, $featureRelationshippropPub->getFeatureRelationshippropId(), $comparison);
        } elseif ($featureRelationshippropPub instanceof PropelObjectCollection) {
            return $this
                ->useFeatureRelationshippropPubQuery()
                ->filterByPrimaryKeys($featureRelationshippropPub->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureRelationshippropPub() only accepts arguments of type FeatureRelationshippropPub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureRelationshippropPub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureRelationshippropQuery The current query, for fluid interface
     */
    public function joinFeatureRelationshippropPub($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureRelationshippropPub');

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
            $this->addJoinObject($join, 'FeatureRelationshippropPub');
        }

        return $this;
    }

    /**
     * Use the FeatureRelationshippropPub relation FeatureRelationshippropPub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureRelationshippropPubQuery A secondary query class using the current class as primary query
     */
    public function useFeatureRelationshippropPubQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureRelationshippropPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureRelationshippropPub', '\cli_db\propel\FeatureRelationshippropPubQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   FeatureRelationshipprop $featureRelationshipprop Object to remove from the list of results
     *
     * @return FeatureRelationshippropQuery The current query, for fluid interface
     */
    public function prune($featureRelationshipprop = null)
    {
        if ($featureRelationshipprop) {
            $this->addUsingAlias(FeatureRelationshippropPeer::FEATURE_RELATIONSHIPPROP_ID, $featureRelationshipprop->getFeatureRelationshippropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
