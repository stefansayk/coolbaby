# after pressing the swap key the legend sits in the off hand: put everything back exactly as it was
summon minecraft:item_display ~ ~ ~ {Tags:["mythic.tmp"]}
item replace entity @e[type=minecraft:item_display,tag=mythic.tmp,limit=1,sort=nearest] contents from entity @s weapon.offhand
item replace entity @s weapon.offhand from entity @s weapon.mainhand
item replace entity @s weapon.mainhand from entity @e[type=minecraft:item_display,tag=mythic.tmp,limit=1,sort=nearest] contents
kill @e[type=minecraft:item_display,tag=mythic.tmp]
