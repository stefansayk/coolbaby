# Frostnova: Eiswelle: 4 Schaden im Umkreis von 6 Blöcken, Gegner erstarren 4 s.
tag @e[type=!#mythic:not_target,tag=!mythic.caster,distance=..6] add mythic.t
execute as @e[tag=mythic.t] run damage @s 4 minecraft:freeze by @p[tag=mythic.caster]
effect give @e[tag=mythic.t] minecraft:slowness 4 3
effect give @e[tag=mythic.t] minecraft:mining_fatigue 4 1
execute as @e[tag=mythic.t,type=!minecraft:player] run data merge entity @s {TicksFrozen:300}
particle minecraft:snowflake ~ ~0.5 ~ 3 0.3 3 0.05 200
particle minecraft:item_snowball ~ ~1 ~ 3 0.5 3 0.1 60
playsound minecraft:block.glass.break player @a ~ ~ ~ 1 0.5
playsound minecraft:entity.player.hurt_freeze player @a ~ ~ ~ 1 0.8
tag @e[tag=mythic.t] remove mythic.t
