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
use cli_db\propel\Quantification;
use cli_db\propel\QuantificationRelationship;
use cli_db\propel\QuantificationRelationshipPeer;
use cli_db\propel\QuantificationRelationshipQuery;

/**
 * Base class that represents a query for the 'quantification_relationship' table.
 *
 *
 *
 * @method QuantificationRelationshipQuery orderByQuantificationRelationshipId($order = Criteria::ASC) Order by the quantification_relationship_id column
 * @method QuantificationRelationshipQuery orderBySubjectId($order = Criteria::ASC) Order by the subject_id column
 * @method QuantificationRelationshipQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method QuantificationRelationshipQuery orderByObjectId($order = Criteria::ASC) Order by the object_id column
 *
 * @method QuantificationRelationshipQuery groupByQuantificationRelationshipId() Group by the quantification_relationship_id column
 * @method QuantificationRelationshipQuery groupBySubjectId() Group by the subject_id column
 * @method QuantificationRelationshipQuery groupByTypeId() Group by the type_id column
 * @method QuantificationRelationshipQuery groupByObjectId() Group by the object_id column
 *
 * @method QuantificationRelationshipQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method QuantificationRelationshipQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method QuantificationRelationshipQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method QuantificationRelationshipQuery leftJoinQuantificationRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the QuantificationRelatedByObjectId relation
 * @method QuantificationRelationshipQuery rightJoinQuantificationRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the QuantificationRelatedByObjectId relation
 * @method QuantificationRelationshipQuery innerJoinQuantificationRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the QuantificationRelatedByObjectId relation
 *
 * @method QuantificationRelationshipQuery leftJoinQuantificationRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the QuantificationRelatedBySubjectId relation
 * @method QuantificationRelationshipQuery rightJoinQuantificationRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the QuantificationRelatedBySubjectId relation
 * @method QuantificationRelationshipQuery innerJoinQuantificationRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the QuantificationRelatedBySubjectId relation
 *
 * @method QuantificationRelationshipQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method QuantificationRelationshipQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method QuantificationRelationshipQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method QuantificationRelationship findOne(PropelPDO $con = null) Return the first QuantificationRelationship matching the query
 * @method QuantificationRelationship findOneOrCreate(PropelPDO $con = null) Return the first QuantificationRelationship matching the query, or a new QuantificationRelationship object populated from the query conditions when no match is found
 *
 * @method QuantificationRelationship findOneBySubjectId(int $subject_id) Return the first QuantificationRelationship filtered by the subject_id column
 * @method QuantificationRelationship findOneByTypeId(int $type_id) Return the first QuantificationRelationship filtered by the type_id column
 * @method QuantificationRelationship findOneByObjectId(int $object_id) Return the first QuantificationRelationship filtered by the object_id column
 *
 * @method array findByQuantificationRelationshipId(int $quantification_relationship_id) Return QuantificationRelationship objects filtered by the quantification_relationship_id column
 * @method array findBySubjectId(int $subject_id) Return QuantificationRelationship objects filtered by the subject_id column
 * @method array findByTypeId(int $type_id) Return QuantificationRelationship objects filtered by the type_id column
 * @method array findByObjectId(int $object_id) Return QuantificationRelationship objects filtered by the object_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseQuantificationRelationshipQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseQuantificationRelationshipQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\QuantificationRelationship', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new QuantificationRelationshipQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   QuantificationRelationshipQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return QuantificationRelationshipQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof QuantificationRelationshipQuery) {
            return $criteria;
        }
        $query = new QuantificationRelationshipQuery();
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
     * @return   QuantificationRelationship|QuantificationRelationship[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = QuantificationRelationshipPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(QuantificationRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 QuantificationRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByQuantificationRelationshipId($key, $con = null)
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
     * @return                 QuantificationRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "quantification_relationship_id", "subject_id", "type_id", "object_id" FROM "quantification_relationship" WHERE "quantification_relationship_id" = :p0';
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
            $obj = new QuantificationRelationship();
            $obj->hydrate($row);
            QuantificationRelationshipPeer::addInstanceToPool($obj, (string) $key);
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
     * @return QuantificationRelationship|QuantificationRelationship[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|QuantificationRelationship[]|mixed the list of results, formatted by the current formatter
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
     * @return QuantificationRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(QuantificationRelationshipPeer::QUANTIFICATION_RELATIONSHIP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return QuantificationRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(QuantificationRelationshipPeer::QUANTIFICATION_RELATIONSHIP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the quantification_relationship_id column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantificationRelationshipId(1234); // WHERE quantification_relationship_id = 1234
     * $query->filterByQuantificationRelationshipId(array(12, 34)); // WHERE quantification_relationship_id IN (12, 34)
     * $query->filterByQuantificationRelationshipId(array('min' => 12)); // WHERE quantification_relationship_id >= 12
     * $query->filterByQuantificationRelationshipId(array('max' => 12)); // WHERE quantification_relationship_id <= 12
     * </code>
     *
     * @param     mixed $quantificationRelationshipId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationRelationshipQuery The current query, for fluid interface
     */
    public function filterByQuantificationRelationshipId($quantificationRelationshipId = null, $comparison = null)
    {
        if (is_array($quantificationRelationshipId)) {
            $useMinMax = false;
            if (isset($quantificationRelationshipId['min'])) {
                $this->addUsingAlias(QuantificationRelationshipPeer::QUANTIFICATION_RELATIONSHIP_ID, $quantificationRelationshipId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantificationRelationshipId['max'])) {
                $this->addUsingAlias(QuantificationRelationshipPeer::QUANTIFICATION_RELATIONSHIP_ID, $quantificationRelationshipId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationRelationshipPeer::QUANTIFICATION_RELATIONSHIP_ID, $quantificationRelationshipId, $comparison);
    }

    /**
     * Filter the query on the subject_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySubjectId(1234); // WHERE subject_id = 1234
     * $query->filterBySubjectId(array(12, 34)); // WHERE subject_id IN (12, 34)
     * $query->filterBySubjectId(array('min' => 12)); // WHERE subject_id >= 12
     * $query->filterBySubjectId(array('max' => 12)); // WHERE subject_id <= 12
     * </code>
     *
     * @see       filterByQuantificationRelatedBySubjectId()
     *
     * @param     mixed $subjectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationRelationshipQuery The current query, for fluid interface
     */
    public function filterBySubjectId($subjectId = null, $comparison = null)
    {
        if (is_array($subjectId)) {
            $useMinMax = false;
            if (isset($subjectId['min'])) {
                $this->addUsingAlias(QuantificationRelationshipPeer::SUBJECT_ID, $subjectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subjectId['max'])) {
                $this->addUsingAlias(QuantificationRelationshipPeer::SUBJECT_ID, $subjectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationRelationshipPeer::SUBJECT_ID, $subjectId, $comparison);
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
     * @return QuantificationRelationshipQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(QuantificationRelationshipPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(QuantificationRelationshipPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationRelationshipPeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the object_id column
     *
     * Example usage:
     * <code>
     * $query->filterByObjectId(1234); // WHERE object_id = 1234
     * $query->filterByObjectId(array(12, 34)); // WHERE object_id IN (12, 34)
     * $query->filterByObjectId(array('min' => 12)); // WHERE object_id >= 12
     * $query->filterByObjectId(array('max' => 12)); // WHERE object_id <= 12
     * </code>
     *
     * @see       filterByQuantificationRelatedByObjectId()
     *
     * @param     mixed $objectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationRelationshipQuery The current query, for fluid interface
     */
    public function filterByObjectId($objectId = null, $comparison = null)
    {
        if (is_array($objectId)) {
            $useMinMax = false;
            if (isset($objectId['min'])) {
                $this->addUsingAlias(QuantificationRelationshipPeer::OBJECT_ID, $objectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objectId['max'])) {
                $this->addUsingAlias(QuantificationRelationshipPeer::OBJECT_ID, $objectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationRelationshipPeer::OBJECT_ID, $objectId, $comparison);
    }

    /**
     * Filter the query by a related Quantification object
     *
     * @param   Quantification|PropelObjectCollection $quantification The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantificationRelatedByObjectId($quantification, $comparison = null)
    {
        if ($quantification instanceof Quantification) {
            return $this
                ->addUsingAlias(QuantificationRelationshipPeer::OBJECT_ID, $quantification->getQuantificationId(), $comparison);
        } elseif ($quantification instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationRelationshipPeer::OBJECT_ID, $quantification->toKeyValue('PrimaryKey', 'QuantificationId'), $comparison);
        } else {
            throw new PropelException('filterByQuantificationRelatedByObjectId() only accepts arguments of type Quantification or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the QuantificationRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return QuantificationRelationshipQuery The current query, for fluid interface
     */
    public function joinQuantificationRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('QuantificationRelatedByObjectId');

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
            $this->addJoinObject($join, 'QuantificationRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the QuantificationRelatedByObjectId relation Quantification object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\QuantificationQuery A secondary query class using the current class as primary query
     */
    public function useQuantificationRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuantificationRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'QuantificationRelatedByObjectId', '\cli_db\propel\QuantificationQuery');
    }

    /**
     * Filter the query by a related Quantification object
     *
     * @param   Quantification|PropelObjectCollection $quantification The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantificationRelatedBySubjectId($quantification, $comparison = null)
    {
        if ($quantification instanceof Quantification) {
            return $this
                ->addUsingAlias(QuantificationRelationshipPeer::SUBJECT_ID, $quantification->getQuantificationId(), $comparison);
        } elseif ($quantification instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationRelationshipPeer::SUBJECT_ID, $quantification->toKeyValue('PrimaryKey', 'QuantificationId'), $comparison);
        } else {
            throw new PropelException('filterByQuantificationRelatedBySubjectId() only accepts arguments of type Quantification or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the QuantificationRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return QuantificationRelationshipQuery The current query, for fluid interface
     */
    public function joinQuantificationRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('QuantificationRelatedBySubjectId');

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
            $this->addJoinObject($join, 'QuantificationRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the QuantificationRelatedBySubjectId relation Quantification object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\QuantificationQuery A secondary query class using the current class as primary query
     */
    public function useQuantificationRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuantificationRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'QuantificationRelatedBySubjectId', '\cli_db\propel\QuantificationQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(QuantificationRelationshipPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationRelationshipPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return QuantificationRelationshipQuery The current query, for fluid interface
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
     * @param   QuantificationRelationship $quantificationRelationship Object to remove from the list of results
     *
     * @return QuantificationRelationshipQuery The current query, for fluid interface
     */
    public function prune($quantificationRelationship = null)
    {
        if ($quantificationRelationship) {
            $this->addUsingAlias(QuantificationRelationshipPeer::QUANTIFICATION_RELATIONSHIP_ID, $quantificationRelationship->getQuantificationRelationshipId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
