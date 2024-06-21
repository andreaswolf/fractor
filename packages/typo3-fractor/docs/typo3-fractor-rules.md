# 13 Rules Overview

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
