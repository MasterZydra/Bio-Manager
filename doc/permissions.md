# Berechtigungen
| Berechtigung | Beschreibung |
| --- | --- |
| isAdmin | Administrator-Rechte |
| isDeveloper | Entwickler-Rechte |
| isMaintainer | Rechte zum Pflegen der Inhalte |
| isSupplier | Rechte um eigene Daten zu sehen |
| isInspector | Rechte zum Lesen der Inhalte |

# Dateien-/Seitenberechtigung
x = Zugriff erlaubt  
o = Beschränkte Möglichkeiten

| Seite | Admin | Developer | Maintainer | Supplier | Inspector | Bemerkung |
| --- | :-: | :-: | :-: | :-: | :-: | --- |
| addDeliveryNote.php | | | x | | | |
| addInvoice.php | | | x | | | |
| addPlot.php | | | x | | | |
| addPricing.php | | | x | | | |
| addProduct.php | | | x | | | |
| addRecipient.php | | | x | | | |
| addSetting.php | x | x | | | | Beide notwendig |
| addSupplier.php | | | x | | | |
| addUser.php | x | | | | | |

| Seite | Admin | Developer | Maintainer | Supplier | Inspector | Bemerkung |
| --- | :-: | :-: | :-: | :-: | :-: | --- |
| deleteDeliveryNote.php | | | x | | | |
| deleteInvoice.php | | | x | | | |
| deletePlot.php | | | x | | | |
| deletePricing.php | | | x | | | |
| deleteProduct.php | | | x | | | |
| deleteRecipient.php | | | x | | | |
| deleteSetting.php | | x | | | | |
| deleteSupplier.php | | | x | | | |
| deleteUser.php | x | | | | | |

| Seite | Admin | Developer | Maintainer | Supplier | Inspector | Bemerkung |
| --- | :-: | :-: | :-: | :-: | :-: | --- |
| editCropVolumeDistribution.php | | | x | | | |
| editDeliveryNote.php | | | x | | | |
| editPlot.php | | | x | | | |
| editPricing.php | | | x | | | |
| editProduct.php | | | x | | | |
| editRecipient.php | | | x | | | |
| editSetting.php | x | | | | | |
| editSupplier.php | | | x | | | |
| editUser.php | x | | | | | |

| Seite | Admin | Developer | Maintainer | Supplier | Inspector | Bemerkung |
| --- | :-: | :-: | :-: | :-: | :-: | --- |
| showActiveSupplier.php | | | x | | x | |
| showCropVolumeDistribution.php | | | x | | x | |
| showDeliveryNote_OpenVolumeDistribution.php | | | x | | | |
| showInvoice.php | | | x | | x | |
| showMyDeliveryNote.php | | | | x | | |
| showSupplierPayments.php | | | x | | x | |

| Seite | Admin | Developer | Maintainer | Supplier | Inspector | Bemerkung |
| --- | :-: | :-: | :-: | :-: | :-: | --- |
| about.php | | | | | | Jeder angemeldete |
| changePwd.php | | | | | | Jeder angemeldete |
| changeUserPwd.php | x | | | | | |
| developerOptions.php | | x | | | | |
| impressum.php | | | | | | Jeder |
| index.php | | | | | | Jeder |
| login.php | | | | | | Jeder |
| logout.php | | | | | | Jeder |

| Seite | Admin | Developer | Maintainer | Supplier | Inspector | Bemerkung |
| --- | :-: | :-: | :-: | :-: | :-: | --- |
| deliveryNote.php | | | x | | o | |
| invoice.php | | | x | | o | |
| plot.php | | | x | | o | |
| pricing.php | | | x | | o | |
| product.php | | | x | | o | |
| recipient | | | x | | o | |
| setting.php | x | | | | | |
| supplier.php | | | x | | o | |
| user.php | x | | | | | |