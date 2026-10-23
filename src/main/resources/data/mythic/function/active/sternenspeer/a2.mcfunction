# Sternensprung: Katapultiert dich 10 Blöcke hoch, danach gleitest du sanft herab.
effect give @s minecraft:levitation 1 9 true
effect give @s minecraft:slow_falling 6 0 true
particle minecraft:end_rod ~ ~0.2 ~ 0.6 0.1 0.6 0.15 60
particle minecraft:firework ~ ~ ~ 0.5 0.1 0.5 0.1 25
playsound minecraft:entity.firework_rocket.launch player @a ~ ~ ~ 1 0.7
playsound minecraft:block.amethyst_block.chime player @a ~ ~ ~ 1 1.5
