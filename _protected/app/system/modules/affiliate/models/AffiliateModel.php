<?php
/**
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Module / Affiliate / Model
 */
namespace PH7;
use PH7\Framework\Mvc\Model\Engine\Db;

class AffiliateModel extends AffiliateCoreModel
{

    /**
     * Add a new affiliate.
     *
     * @param array $aData
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function join(array $aData)
    {
        $rStmt = Db::getInstance()->prepare('INSERT INTO' . Db::prefix('Affiliate') . '(email, username, password, firstName, lastName, sex, birthDate, country, city, state, zipCode, active, ip, hashValidation, prefixSalt, suffixSalt, joinDate, lastActivity)
        VALUES (:email, :username, :password, :firstName, :lastName, :sex, :birthDate, :country, :city, :state, :zipCode, :active, :ip, :hashValidation, :prefixSalt, :suffixSalt, :joinDate, :lastActivity)');
        $rStmt->bindValue(':email', $aData['email'], \PDO::PARAM_STR);
        $rStmt->bindValue(':username', $aData['username'], \PDO::PARAM_STR);
        $rStmt->bindValue(':password', Framework\Security\Security::hashPwd($aData['prefix_salt'], $aData['password'], $aData['suffix_salt']), \PDO::PARAM_INT);
        $rStmt->bindValue(':firstName', $aData['first_name'], \PDO::PARAM_STR);
        $rStmt->bindValue(':lastName', $aData['last_name'], \PDO::PARAM_STR);
        $rStmt->bindValue(':sex', $aData['sex'], \PDO::PARAM_STR);
        $rStmt->bindValue(':birthDate', $aData['birth_date'], \PDO::PARAM_STR);
        $rStmt->bindValue(':country', $aData['country'], \PDO::PARAM_STR);
        $rStmt->bindValue(':city', $aData['city'], \PDO::PARAM_STR);
        $rStmt->bindValue(':state', $aData['state'], \PDO::PARAM_STR);
        $rStmt->bindValue(':zipCode', $aData['zip_code'], \PDO::PARAM_STR);
        $rStmt->bindValue(':active', $aData['is_active'], \PDO::PARAM_INT);
        $rStmt->bindValue(':ip', $aData['ip'], \PDO::PARAM_INT);
        $rStmt->bindValue(':hashValidation', $aData['hash_validation'], \PDO::PARAM_STR);
        $rStmt->bindValue(':prefixSalt', $aData['prefix_salt'], \PDO::PARAM_INT);
        $rStmt->bindValue(':suffixSalt', $aData['suffix_salt'], \PDO::PARAM_INT);
        $rStmt->bindValue(':joinDate', $aData['current_date'], \PDO::PARAM_STR);
        $rStmt->bindValue(':lastActivity', $aData['current_date'], \PDO::PARAM_STR);
        return $rStmt->execute();
    }

    /**
     * Add a reference affiliate.
     *
     * @param integer $iProfileId
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function addRefer($iProfileId)
    {
        $rStmt = Db::getInstance()->prepare('UPDATE' . Db::prefix('Affiliate') . 'SET refer =refer+1 WHERE profileId = :profileId');
        $rStmt->bindValue(':profileId', $iProfileId, \PDO::PARAM_INT);
        Db::free($rStmt);
        return $rStmt->execute();
    }

    /**
     * Search an affiliated.
     *
     * @param mixed (integer for profile ID or string for a keyword) $mLooking
     * @param boolean $bCount Put 'true' for count the affiliates or 'false' for the result of affiliates.
     * @param string $sOrderBy
     * @param string $sSort
     * @param integer $iOffset
     * @param integer $iLimit
     * @return mixed (integer for the number affiliates returned or string for the affiliates list returned)
     */
    public function searchAff($mLooking, $bCount, $sOrderBy, $sSort, $iOffset, $iLimit)
    {
        $bCount = (bool) $bCount;
        $iOffset = (int) $iOffset;
        $iLimit = (int) $iLimit;

        $sSqlLimit = (!$bCount) ? ' LIMIT :offset, :limit' : '';
        $sSqlSelect = (!$bCount) ? '*' : 'COUNT(profileId) AS totalUsers';
        $sSqlWhere = (ctype_digit($mLooking)) ? ' WHERE profileId = :looking' : ' WHERE username LIKE :looking OR firstName LIKE :looking OR lastName LIKE :looking OR email LIKE :looking OR bankAccount LIKE :looking OR sex LIKE :looking OR ip LIKE :looking';
        $sSqlOrder = SearchCoreModel::order($sOrderBy, $sSort);

        $rStmt = Db::getInstance()->prepare('SELECT ' . $sSqlSelect . ' FROM' . Db::prefix('Affiliate') . $sSqlWhere . $sSqlOrder . $sSqlLimit);

        (ctype_digit($mLooking)) ? $rStmt->bindValue(':looking', $mLooking, \PDO::PARAM_INT) : $rStmt->bindValue(':looking', '%' . $mLooking . '%', \PDO::PARAM_STR);

        if (!$bCount)
        {
            $rStmt->bindParam(':offset', $iOffset, \PDO::PARAM_INT);
            $rStmt->bindParam(':limit', $iLimit, \PDO::PARAM_INT);
        }

        $rStmt->execute();

        if (!$bCount)
        {
            $mData = $rStmt->fetchAll(\PDO::FETCH_OBJ);
            Db::free($rStmt);
        }
        else
        {
            $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
            Db::free($rStmt);
            $mData = (int) $oRow->totalUsers;
            unset($oRow);
        }
        return $mData;
    }

    /**
     * Adding an Affiliate.
     *
     * @param array $aData
     * @return integer The ID of the Affiliate.
     */
    public function add(array $aData)
    {
        $sCurrentDate = (new Framework\Date\CDateTime)->get()->dateTime('Y-m-d H:i:s');

        $rStmt = Db::getInstance()->prepare('INSERT INTO' . Db::prefix('Affiliate') . '(email, username, password, firstName, lastName, sex, birthDate, country, city, state, zipCode, phone, description, website, bankAccount, ip, prefixSalt, suffixSalt, joinDate, lastActivity)
        VALUES (:email, :username, :password, :firstName, :lastName, :sex, :birthDate, :country, :city, :state, :zipCode, :phone, :description, :website, :bankAccount, :ip, :prefixSalt, :suffixSalt, :joinDate, :lastActivity)');
        $rStmt->bindValue(':email',   trim($aData['email']), \PDO::PARAM_STR);
        $rStmt->bindValue(':username', trim($aData['username']), \PDO::PARAM_STR);
        $rStmt->bindValue(':password', Framework\Security\Security::hashPwd($aData['prefix_salt'], $aData['password'], $aData['suffix_salt']), \PDO::PARAM_INT);
        $rStmt->bindValue(':firstName', $aData['first_name'], \PDO::PARAM_STR);
        $rStmt->bindValue(':lastName', $aData['last_name'], \PDO::PARAM_STR);
        $rStmt->bindValue(':sex', $aData['sex'], \PDO::PARAM_STR);
        $rStmt->bindValue(':birthDate', $aData['birth_date'], \PDO::PARAM_STR);
        $rStmt->bindValue(':country', $aData['country'], \PDO::PARAM_STR);
        $rStmt->bindValue(':city', $aData['city'], \PDO::PARAM_STR);
        $rStmt->bindValue(':state', $aData['state'], \PDO::PARAM_STR);
        $rStmt->bindValue(':zipCode', $aData['zip_code'], \PDO::PARAM_STR);
        $rStmt->bindValue(':phone', $aData['phone'], \PDO::PARAM_STR);
        $rStmt->bindValue(':description', $aData['description'], \PDO::PARAM_STR);
        $rStmt->bindValue(':website', $aData['website'], \PDO::PARAM_STR);
        $rStmt->bindValue(':bankAccount', $aData['bank_account'], \PDO::PARAM_STR);
        $rStmt->bindValue(':ip', $aData['ip'], \PDO::PARAM_INT);
        $rStmt->bindValue(':prefixSalt', $aData['prefix_salt'], \PDO::PARAM_INT);
        $rStmt->bindValue(':suffixSalt', $aData['suffix_salt'], \PDO::PARAM_INT);
        $rStmt->bindValue(':joinDate', $sCurrentDate, \PDO::PARAM_STR);
        $rStmt->bindValue(':lastActivity', $sCurrentDate, \PDO::PARAM_STR);
        $rStmt->execute();
        Db::free($rStmt);
        return Db::getInstance()->lastInsertId();
    }

}
