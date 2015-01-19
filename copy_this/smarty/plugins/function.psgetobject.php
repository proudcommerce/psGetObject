<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Thanks to D3 for source code snippet.
 * We created a official OXID eShop CE pull reqeust, but was not merged
 * and closed :-( https://github.com/OXID-eSales/oxideshop_ce/pull/177
 * 
 * @copyright (c) Proud Sourcing GmbH | 2015
 * @link www.proudcommerce.com
 * @package psGetObject
 * @version 1.0.0
 **/
 
/**
 * Smarty plugin
 * -------------------------------------------------------------
 * File: function.psgetobject.php
 * Type: function
 * Name: getPsObject
 * Purpose: Output core class object
 * add [{ psgetobject type="oxarticle" ident="abc123" field="oxtitle" assign="oProduct" lang=1 }] where you want to display content
 * -------------------------------------------------------------
 *
 * @param $params
 * @param $smarty Smarty
 *
 * @return oxbase
 * @throws Exception
 */
function smarty_function_psgetobject( $params, &$smarty )
{
    $iLang = oxRegistry::getLang()->getBaseLanguage();
    $sIdent = isset( $params['ident'] ) ? (string)$params['ident'] : '';
    $sType = isset( $params['type'] ) ? (string)$params['type'] : '';
    $sField = isset( $params['field'] ) ? (string)$params['field'] : '';
    $sAssign = isset( $params['assign'] ) ? (string)$params['assign'] : '';
    $iLang = isset( $params['lang'] ) ? (int)$params['lang'] : $iLang;
    $mRet = null;

    if($sType == "")
    {
        throw new Exception('You need to define an object type! Use type="myClass".');
    }

    $oObject = oxNew($sType);
    if($sIdent != "" && $oObject->loadInLang($iLang, $sIdent) == false)
    {
        throw new Exception("Couldn't load ident: $sIdent");
    }

    if($sField)
    {
        $mRet = $oObject->getFieldData($sField);
    }
    else
    {
        $mRet = $oObject;
    }

    if($sAssign)
    {
        $smarty->assign($sAssign, $mRet);
    }
    else
    {
        return $mRet;
    }

    return null;
}
