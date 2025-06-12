# 35 Rules Overview

## AbstractMessageGetSeverityFluidFractor

Migrate to severity property 'value'

- class: [`a9f\Typo3Fractor\TYPO3v12\Fluid\AbstractMessageGetSeverityFluidFractor`](../rules/TYPO3v12/Fluid/AbstractMessageGetSeverityFluidFractor.php)

```diff
-<div class="{severityClassMapping.{status.severity}}">
+<div class="{severityClassMapping.{status.severity.value}}">
     <!-- stuff happens here -->
 </div>
```

<br>

## ChangeLogoutHandlingInFeLoginFractor

Change logout handling in ext:felogin

- class: [`a9f\Typo3Fractor\TYPO3v14\Fluid\ChangeLogoutHandlingInFeLoginFractor`](../rules/TYPO3v14/Fluid/ChangeLogoutHandlingInFeLoginFractor.php)

```diff
-<f:form action="login" actionUri="{actionUri}" target="_top" fieldNamePrefix="">
+<f:form action="login" target="_top" fieldNamePrefix="">
```

<br>

```diff
 <div class="felogin-hidden">
     <f:form.hidden name="logintype" value="logout"/>
+    <f:if condition="{noRedirect} != ''">
+        <f:form.hidden name="noredirect" value="1" />
+    </f:if>
 </div>
```

<br>

## EmailFinisherYamlFractor

Convert single recipient values to array for EmailFinisher

- class: [`a9f\Typo3Fractor\TYPO3v10\Yaml\EmailFinisherYamlFractor`](../rules/TYPO3v10/Yaml/EmailFinisherYamlFractor.php)

```diff
 finishers:
   -
     options:
-      recipientAddress: bar@domain.com
-      recipientName: 'Bar'
+      recipients:
+        bar@domain.com: 'Bar'
```

<br>

## MigrateBooleanAndNullAttributeValuesToNativeTypesFractor

Migrate boolean and null attribute values to native types

- class: [`a9f\Typo3Fractor\TYPO3v13\Fluid\MigrateBooleanAndNullAttributeValuesToNativeTypesFractor`](../rules/TYPO3v13/Fluid/MigrateBooleanAndNullAttributeValuesToNativeTypesFractor.php)

```diff
-<my:viewhelper foo="true" bar="1" />
-<my:viewhelper foo="false" bar="0" />
-<my:viewhelper foo="null" />
+<my:viewhelper foo="{true}" bar="{true}" />
+<my:viewhelper foo="{false}" bar="{false}" />
+<my:viewhelper foo="{null}" />
```

<br>

## MigrateEmailFlagToEmailTypeFlexFormFractor

Migrate email flag to email type

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateEmailFlagToEmailTypeFlexFormFractor`](../rules/TYPO3v12/FlexForm/MigrateEmailFlagToEmailTypeFlexFormFractor.php)

```diff
 <T3DataStructure>
     <sheets>
         <sDEF>
             <ROOT>
                 <sheetTitle>Sheet Title</sheetTitle>
                 <type>array</type>
                 <el>
                     <email_field>
                         <config>
-                            <type>input</type>
-                            <eval>trim,email</eval>
-                            <max>255</max>
+                            <type>email</type>
                         </config>
                     </email_field>
                 </el>
             </ROOT>
         </sDEF>
     </sheets>
 </T3DataStructure>
```

<br>

## MigrateEvalIntAndDouble2ToTypeNumberFlexFormFractor

Migrate eval int and double2 to type number

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateEvalIntAndDouble2ToTypeNumberFlexFormFractor`](../rules/TYPO3v12/FlexForm/MigrateEvalIntAndDouble2ToTypeNumberFlexFormFractor.php)

```diff
 <T3DataStructure>
     <sheets>
         <sDEF>
             <ROOT>
                 <sheetTitle>Sheet Title</sheetTitle>
                 <type>array</type>
                 <el>
                     <int_field>
                         <label>int field</label>
                         <config>
-                            <type>input</type>
-                            <eval>int</eval>
+                            <type>number</type>
                         </config>
                     </int_field>
                     <double2_field>
                         <label>double2 field</label>
                         <config>
-                            <type>input</type>
-                            <eval>double2</eval>
+                            <type>number</type>
+                            <format>decimal</format>
                         </config>
                     </double2_field>
                 </el>
             </ROOT>
         </sDEF>
     </sheets>
 </T3DataStructure>
```

<br>

## MigrateIncludeTypoScriptSyntaxFractor

Migrate INCLUDE_TYPOSCRIPT TypoScript syntax to `@import`

- class: [`a9f\Typo3Fractor\TYPO3v13\TypoScript\MigrateIncludeTypoScriptSyntaxFractor`](../rules/TYPO3v13/TypoScript/MigrateIncludeTypoScriptSyntaxFractor.php)

```diff
-<INCLUDE_TYPOSCRIPT: source="FILE:EXT:my_extension/Configuration/TypoScript/myMenu.typoscript">
+@import 'EXT:my_extension/Configuration/TypoScript/myMenu.typoscript'
```

<br>

```diff
-<INCLUDE_TYPOSCRIPT: source="DIR:EXT:my_extension/Configuration/TypoScript/" extensions="typoscript">
+@import 'EXT:my_extension/Configuration/TypoScript/*.typoscript'
```

<br>

```diff
-<INCLUDE_TYPOSCRIPT: source="DIR:EXT:my_extension/Configuration/TypoScript/" extensions="typoscript,ts">
+@import 'EXT:my_extension/Configuration/TypoScript/*.typoscript'
```

<br>

```diff
-<INCLUDE_TYPOSCRIPT: source="FILE:EXT:my_extension/Configuration/TypoScript/user.typoscript" condition="[frontend.user.isLoggedIn]">
+[frontend.user.isLoggedIn]
+    @import 'EXT:my_extension/Configuration/TypoScript/user.typoscript'
+[end]
```

<br>

## MigrateInternalTypeFolderToTypeFolderFlexFormFractor

Migrates TCA internal_type into new new TCA type folder

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateInternalTypeFolderToTypeFolderFlexFormFractor`](../rules/TYPO3v12/FlexForm/MigrateInternalTypeFolderToTypeFolderFlexFormFractor.php)

```diff
 <T3DataStructure>
     <sheets>
         <sDEF>
             <ROOT>
                 <sheetTitle>Sheet Title</sheetTitle>
                 <type>array</type>
                 <el>
                     <aColumn>
                         <config>
-                            <type>group</type>
-                            <internal_type>folder</internal_type>
+                            <type>folder</type>
                         </config>
                     </aColumn>
                 </el>
             </ROOT>
         </sDEF>
     </sheets>
 </T3DataStructure>
```

<br>

## MigrateItemsIndexedKeysToAssociativeFractor

Migrates indexed item array keys to associative for type select, radio and check

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateItemsIndexedKeysToAssociativeFractor`](../rules/TYPO3v12/FlexForm/MigrateItemsIndexedKeysToAssociativeFractor.php)

```diff
 <T3DataStructure>
     <sheets>
         <sDEF>
             <ROOT>
                 <sheetTitle>Sheet Title</sheetTitle>
                 <type>array</type>
                 <el>
                     <selectSingleColumn>
                         <config>
                             <type>select</type>
                             <renderType>selectSingle</renderType>
                             <items type="array">
                                 <numIndex index="0" type="array">
-                                    <numIndex index="0"/>
-                                    <numIndex index="1"/>
+                                    <label/>
+                                    <value/>
                                 </numIndex>
                                 <numIndex index="1" type="array">
-                                    <numIndex index="0">Label 1</numIndex>
-                                    <numIndex index="1">1</numIndex>
+                                    <label>Label 1</label>
+                                    <value>1</value>
                                 </numIndex>
                                 <numIndex index="2" type="array">
-                                    <numIndex index="0">Label 2</numIndex>
-                                    <numIndex index="1">2</numIndex>
+                                    <label>Label 2</label>
+                                    <value>2</value>
                                 </numIndex>
                                 <numIndex index="3" type="array">
-                                    <numIndex index="0">Label 3</numIndex>
-                                    <numIndex index="1">3</numIndex>
+                                    <label>Label 3</label>
+                                    <value>3</value>
                                 </numIndex>
                             </items>
                         </config>
                     </selectSingleColumn>
                 </el>
             </ROOT>
         </sDEF>
     </sheets>
 </T3DataStructure>
```

<br>

## MigrateNullFlagFlexFormFractor

Migrate null flag

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateNullFlagFlexFormFractor`](../rules/TYPO3v12/FlexForm/MigrateNullFlagFlexFormFractor.php)

```diff
 <T3DataStructure>
     <sheets>
         <sDEF>
             <ROOT>
                 <sheetTitle>Sheet Title</sheetTitle>
                 <type>array</type>
                 <el>
                     <aFlexField>
                         <config>
-                            <eval>null</eval>
+                            <nullable>true</nullable>
                         </config>
                     </aFlexField>
                 </el>
             </ROOT>
         </sDEF>
     </sheets>
 </T3DataStructure>
```

<br>

## MigratePasswordAndSaltedPasswordToPasswordTypeFlexFormFractor

Migrate password and salted password to password type

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigratePasswordAndSaltedPasswordToPasswordTypeFlexFormFractor`](../rules/TYPO3v12/FlexForm/MigratePasswordAndSaltedPasswordToPasswordTypeFlexFormFractor.php)

```diff
 <T3DataStructure>
     <sheets>
         <sDEF>
             <ROOT>
                 <sheetTitle>Sheet Title</sheetTitle>
                 <type>array</type>
                 <el>
                     <password_field>
                         <config>
-                            <type>input</type>
-                            <eval>trim,password,saltedPassword</eval>
+                            <type>password</type>
                         </config>
                     </password_field>
                     <another_password_field>
                         <config>
-                            <type>input</type>
-                            <eval>trim,password</eval>
+                            <type>password</type>
+                            <hashed>false</hashed>
                         </config>
                     </another_password_field>
                 </el>
             </ROOT>
         </sDEF>
     </sheets>
 </T3DataStructure>
```

<br>

## MigrateRenderTypeColorpickerToTypeColorFlexFormFractor

Migrate renderType colorpicker to type color

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateRenderTypeColorpickerToTypeColorFlexFormFractor`](../rules/TYPO3v12/FlexForm/MigrateRenderTypeColorpickerToTypeColorFlexFormFractor.php)

```diff
 <T3DataStructure>
     <sheets>
         <sDEF>
             <ROOT>
                 <sheetTitle>Sheet Title</sheetTitle>
                 <type>array</type>
                 <el>
                     <a_color_field>
                         <config>
-                            <type>input</type>
-                            <renderType>colorpicker</renderType>
+                            <type>color</type>
                             <required>1</required>
                             <size>20</size>
-                            <max>1234</max>
-                            <eval>trim,null</eval>
                             <valuePicker>
                                 <items type="array">
                                     <numIndex index="0" type="array">
                                         <numIndex index="0">typo3 orange</numIndex>
                                         <numIndex index="1">#FF8700</numIndex>
                                     </numIndex>
                                 </items>
                             </valuePicker>
                         </config>
                     </a_color_field>
                 </el>
             </ROOT>
         </sDEF>
     </sheets>
 </T3DataStructure>
```

<br>

## MigrateRequiredFlagFlexFormFractor

Migrate required flag

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateRequiredFlagFlexFormFractor`](../rules/TYPO3v12/FlexForm/MigrateRequiredFlagFlexFormFractor.php)

```diff
 <T3DataStructure>
     <sheets>
         <sDEF>
             <ROOT>
                 <sheetTitle>Sheet Title</sheetTitle>
                 <type>array</type>
                 <el>
                     <aColumn>
                         <config>
-                            <eval>trim,required</eval>
+                            <eval>trim</eval>
+                            <required>1</required>
                         </config>
                     </aColumn>
                 </el>
             </ROOT>
         </sDEF>
     </sheets>
 </T3DataStructure>
```

<br>

## MigrateTypeNoneColsToSizeFlexFormFractor

Migrates option cols to size for TCA type none

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateTypeNoneColsToSizeFlexFormFractor`](../rules/TYPO3v12/FlexForm/MigrateTypeNoneColsToSizeFlexFormFractor.php)

```diff
 <T3DataStructure>
     <sheets>
         <sDEF>
             <ROOT>
                 <sheetTitle>Sheet Title</sheetTitle>
                 <type>array</type>
                 <el>
                     <aColumn>
                         <config>
                             <type>none</type>
-                            <cols>20</cols>
+                            <size>20</size>
                         </config>
                     </aColumn>
                 </el>
             </ROOT>
         </sDEF>
     </sheets>
 </T3DataStructure>
```

<br>

## RemoveConfigDisablePageExternalUrlFractor

Remove config.disablePageExternalUrl

- class: [`a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveConfigDisablePageExternalUrlFractor`](../rules/TYPO3v12/TypoScript/RemoveConfigDisablePageExternalUrlFractor.php)

```diff
-config.disablePageExternalUrl = 1
+-
```

<br>

## RemoveConfigDoctypeSwitchFractor

Remove config.doctypeSwitch

- class: [`a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveConfigDoctypeSwitchFractor`](../rules/TYPO3v12/TypoScript/RemoveConfigDoctypeSwitchFractor.php)

```diff
-config.doctypeSwitch = 1
+-
```

<br>

## RemoveConfigMetaCharsetFractor

Remove config.metaCharset

- class: [`a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveConfigMetaCharsetFractor`](../rules/TYPO3v12/TypoScript/RemoveConfigMetaCharsetFractor.php)

```diff
-config.metaCharset = 1
+-
```

<br>

## RemoveConfigSendCacheHeadersOnlyWhenLoginDeniedInBranchFractor

Remove config.sendCacheHeaders_onlyWhenLoginDeniedInBranch

- class: [`a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveConfigSendCacheHeadersOnlyWhenLoginDeniedInBranchFractor`](../rules/TYPO3v12/TypoScript/RemoveConfigSendCacheHeadersOnlyWhenLoginDeniedInBranchFractor.php)

```diff
-config.sendCacheHeaders_onlyWhenLoginDeniedInBranch = 1
+-
```

<br>

## RemoveConfigSpamProtectEmailAddressesAsciiOptionFractor

Remove config.spamProtectEmailAddresses with option ascii

- class: [`a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveConfigSpamProtectEmailAddressesAsciiOptionFractor`](../rules/TYPO3v12/TypoScript/RemoveConfigSpamProtectEmailAddressesAsciiOptionFractor.php)

```diff
-config.spamProtectEmailAddresses = ascii
+-
```

<br>

## RemoveExposeNonexistentUserInForgotPasswordDialogSettingInFeLoginFractor

Remove plugin.tx_felogin_login.settings.exposeNonexistentUserInForgotPasswordDialog

- class: [`a9f\Typo3Fractor\TYPO3v14\TypoScript\RemoveExposeNonexistentUserInForgotPasswordDialogSettingInFeLoginFractor`](../rules/TYPO3v14/TypoScript/RemoveExposeNonexistentUserInForgotPasswordDialogSettingInFeLoginFractor.php)

```diff
-plugin.tx_felogin_login.settings.exposeNonexistentUserInForgotPasswordDialog = 1
+-
```

<br>

## RemoveModNewPageWizOverrideWithExtensionFractor

Remove mod.web_list.newPageWiz.overrideWithExtension

- class: [`a9f\Typo3Fractor\TYPO3v8\TypoScript\RemoveModNewPageWizOverrideWithExtensionFractor`](../rules/TYPO3v8/TypoScript/RemoveModNewPageWizOverrideWithExtensionFractor.php)

```diff
-mod.web_list.newPageWiz.overrideWithExtension = 1
+-
```

<br>

## RemoveModWebLayoutDefLangBindingFractor

Remove mod.web_layout.defLangBinding

- class: [`a9f\Typo3Fractor\TYPO3v14\TypoScript\RemoveModWebLayoutDefLangBindingFractor`](../rules/TYPO3v14/TypoScript/RemoveModWebLayoutDefLangBindingFractor.php)

```diff
-mod.web_layout.defLangBinding = 1
+-
```

<br>

## RemoveNewContentElementWizardOptionsFractor

Remove TSConfig mod.web_layout.disableNewContentElementWizard and mod.newContentElementWizard.override

- class: [`a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveNewContentElementWizardOptionsFractor`](../rules/TYPO3v12/TypoScript/RemoveNewContentElementWizardOptionsFractor.php)

```diff
-mod.web_layout.disableNewContentElementWizard = 1
-mod.newContentElementWizard.override = 1
+-
```

<br>

## RemoveNoCacheHashAndUseCacheHashAttributeFluidFractor

Remove noCacheHash="1" and useCacheHash="1" attribute

- class: [`a9f\Typo3Fractor\TYPO3v10\Fluid\RemoveNoCacheHashAndUseCacheHashAttributeFluidFractor`](../rules/TYPO3v10/Fluid/RemoveNoCacheHashAndUseCacheHashAttributeFluidFractor.php)

```diff
-<f:link.page noCacheHash="1">Link</f:link.page>
-<f:link.typolink useCacheHash="1">Link</f:link.typolink>
+<f:link.page>Link</f:link.page>
+<f:link.typolink>Link</f:link.typolink>
```

<br>

## RemoveOptionAlternateBgColorsFractor

Remove mod.web_list.alternateBgColors

- class: [`a9f\Typo3Fractor\TYPO3v7\TypoScript\RemoveOptionAlternateBgColorsFractor`](../rules/TYPO3v7/TypoScript/RemoveOptionAlternateBgColorsFractor.php)

```diff
-mod.web_list.alternateBgColors = 1
+-
```

<br>

## RemovePageDoktypeRecyclerFromUserTsConfigFractor

Remove Page Doktype Recycler (255) from User Tsconfig

- class: [`a9f\Typo3Fractor\TYPO3v13\TypoScript\RemovePageDoktypeRecyclerFromUserTsConfigFractor`](../rules/TYPO3v13/TypoScript/RemovePageDoktypeRecyclerFromUserTsConfigFractor.php)

```diff
 options.pageTree {
-    doktypesToShowInNewPageDragArea = 1,6,4,7,3,254,255,199
+    doktypesToShowInNewPageDragArea = 1,6,4,7,3,254,199
 }
```

<br>

## RemoveTceFormsDomElementFlexFormFractor

Remove TCEForms key from all elements in data structure

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\RemoveTceFormsDomElementFlexFormFractor`](../rules/TYPO3v12/FlexForm/RemoveTceFormsDomElementFlexFormFractor.php)

```diff
 <T3DataStructure>
     <ROOT>
-        <TCEforms>
-            <sheetTitle>aTitle</sheetTitle>
-        </TCEforms>
+        <sheetTitle>aTitle</sheetTitle>
         <type>array</type>
         <el>
             <aFlexField>
-                <TCEforms>
-                    <label>aFlexFieldLabel</label>
-                    <config>
-                        <type>input</type>
-                    </config>
-                </TCEforms>
+                <label>aFlexFieldLabel</label>
+                <config>
+                    <type>input</type>
+                </config>
             </aFlexField>
         </el>
     </ROOT>
 </T3DataStructure>
```

<br>

## RemoveUploadsFromDefaultHtaccessFractor

Remove uploads/ from default .htaccess and add _assets/

- class: [`a9f\Typo3Fractor\TYPO3v14\Htaccess\RemoveUploadsFromDefaultHtaccessFractor`](../rules/TYPO3v14/Htaccess/RemoveUploadsFromDefaultHtaccessFractor.php)

```diff
-RewriteRule ^(?:fileadmin/|typo3conf/|typo3temp/|uploads/) - [L]
+RewriteRule ^(?:fileadmin/|typo3conf/|typo3temp/|_assets/) - [L]
```

<br>

## RemoveUseCacheHashFromTypolinkTypoScriptFractor

Remove useCacheHash TypoScript setting

- class: [`a9f\Typo3Fractor\TYPO3v10\TypoScript\RemoveUseCacheHashFromTypolinkTypoScriptFractor`](../rules/TYPO3v10/TypoScript/RemoveUseCacheHashFromTypolinkTypoScriptFractor.php)

```diff
 typolink {
     parameter = 3
-    useCacheHash = 1
 }
```

<br>

## RemoveWorkspaceModeOptionsFractor

Remove TSConfig options.workspaces.swapMode and options.workspaces.changeStageMode

- class: [`a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveWorkspaceModeOptionsFractor`](../rules/TYPO3v12/TypoScript/RemoveWorkspaceModeOptionsFractor.php)

```diff
-options.workspaces.swapMode = any
-options.workspaces.changeStageMode = any
+-
```

<br>

## RenameConfigXhtmlDoctypeToDoctypeFractor

Migrate typoscript xhtmlDoctype to doctype

- class: [`a9f\Typo3Fractor\TYPO3v12\TypoScript\RenameConfigXhtmlDoctypeToDoctypeFractor`](../rules/TYPO3v12/TypoScript/RenameConfigXhtmlDoctypeToDoctypeFractor.php)

```diff
-config.xhtmlDoctype = 1
+config.doctype = 1
```

<br>

## RenameFeLoginSettingShowForgotPasswordLinkFractor

Rename plugin.tx_felogin_login.settings.showForgotPasswordLink to plugin.tx_felogin_login.settings.showForgotPassword

- class: [`a9f\Typo3Fractor\TYPO3v11\TypoScript\RenameFeLoginSettingShowForgotPasswordLinkFractor`](../rules/TYPO3v11/TypoScript/RenameFeLoginSettingShowForgotPasswordLinkFractor.php)

```diff
-plugin.tx_felogin_login.settings.showForgotPasswordLink = 1
+plugin.tx_felogin_login.settings.showForgotPassword = 1

-styles.content.loginform.showForgotPasswordLink = 0
+styles.content.loginform.showForgotPassword = 0
```

<br>

## RenameTcemainLinkHandlerMailKeyFractor

Rename key mail to email for MailLinkHandler

- class: [`a9f\Typo3Fractor\TYPO3v12\TypoScript\RenameTcemainLinkHandlerMailKeyFractor`](../rules/TYPO3v12/TypoScript/RenameTcemainLinkHandlerMailKeyFractor.php)

```diff
 TCEMAIN.linkHandler {
-    mail {
+    email {
         handler = TYPO3\CMS\Recordlist\LinkHandler\MailLinkHandler
         label = LLL:EXT:recordlist/Resources/Private/Language/locallang_browse_links.xlf:email
         displayAfter = page,file,folder,url
         scanBefore = url
     }
 }
```

<br>

## TranslationFileYamlFractor

Use key translationFiles instead of translationFile

- class: [`a9f\Typo3Fractor\TYPO3v10\Yaml\TranslationFileYamlFractor`](../rules/TYPO3v10/Yaml/TranslationFileYamlFractor.php)

```diff
 TYPO3:
   CMS:
     Form:
       prototypes:
         standard:
           formElementsDefinition:
             Form:
               renderingOptions:
                 translation:
-                  translationFile:
-                    10: 'EXT:form/Resources/Private/Language/locallang.xlf'
+                  translationFiles:
                     20: 'EXT:myextension/Resources/Private/Language/locallang.xlf'
```

<br>

## UseConfigArrayForTSFEPropertiesFractor

Use config array in TSFE instead of deprecated class properties

- class: [`a9f\Typo3Fractor\TYPO3v12\TypoScript\UseConfigArrayForTSFEPropertiesFractor`](../rules/TYPO3v12/TypoScript/UseConfigArrayForTSFEPropertiesFractor.php)

```diff
-page.10.data = TSFE:fileTarget
+page.10.data = TSFE:config|config|fileTarget
```

<br>
