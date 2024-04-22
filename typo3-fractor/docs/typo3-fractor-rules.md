# 1 Rules Overview

## AddRenderTypeToFlexFormFractor

Add renderType node in FlexForm

- class: [`a9f\Typo3Fractor\TYPO3v7\FlexForm\AddRenderTypeToFlexFormFractor`](../rules/TYPO3v7/FlexForm/AddRenderTypeToFlexFormFractor.php)

```diff
 <T3DataStructure>
     <ROOT>
         <sheetTitle>aTitle</sheetTitle>
         <type>array</type>
         <el>
             <a_select_field>
                 <label>Select field</label>
                 <config>
                     <type>select</type>
+                    <renderType>selectSingle</renderType>
                     <items>
                         <numIndex index="0" type="array">
                             <numIndex index="0">Label</numIndex>
                         </numIndex>
                     </items>
                 </config>
             </a_select_field>
         </el>
     </ROOT>
 </T3DataStructure>
```

<br>
