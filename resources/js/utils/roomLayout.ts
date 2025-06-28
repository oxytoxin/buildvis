export interface Room {
    position: [number, number, number];
    dimensions: [number, number, number];
}

export interface HouseDimensions {
    length: number;
    width: number;
    height: number;
}

export function calculateRoomLayout(numRooms: number, dimensions: HouseDimensions): Room[] {
    const rooms: Room[] = [];
    const roomHeight = dimensions.height;

    if (numRooms === 1) {
        // Single room takes full space
        rooms.push({
            position: [0, roomHeight / 2, 0],
            dimensions: [dimensions.width, roomHeight, dimensions.length],
        });
    } else if (numRooms === 2) {
        // Two rooms side by side - random arrangement
        const roomWidth = dimensions.width / 2;

        // Randomly choose between side-by-side or front-back arrangement
        const arrangement = Math.random() > 0.5;

        if (arrangement) {
            // Side by side
            rooms.push({
                position: [-(dimensions.width / 4), roomHeight / 2, 0],
                dimensions: [roomWidth, roomHeight, dimensions.length],
            });
            rooms.push({
                position: [dimensions.width / 4, roomHeight / 2, 0],
                dimensions: [roomWidth, roomHeight, dimensions.length],
            });
        } else {
            // Front and back
            const roomLength = dimensions.length / 2;
            rooms.push({
                position: [0, roomHeight / 2, -(dimensions.length / 4)],
                dimensions: [dimensions.width, roomHeight, roomLength],
            });
            rooms.push({
                position: [0, roomHeight / 2, dimensions.length / 4],
                dimensions: [dimensions.width, roomHeight, roomLength],
            });
        }
    } else if (numRooms === 3) {
        // Three rooms - random arrangement
        const arrangements = [
            // Two on top, one large below
            () => {
                const topRoomWidth = dimensions.width / 2;
                const topRoomLength = dimensions.length / 2;
                const bottomRoomLength = dimensions.length / 2;

                rooms.push({
                    position: [-(dimensions.width / 4), roomHeight / 2, -(dimensions.length / 4)],
                    dimensions: [topRoomWidth, roomHeight, topRoomLength],
                });
                rooms.push({
                    position: [dimensions.width / 4, roomHeight / 2, -(dimensions.length / 4)],
                    dimensions: [topRoomWidth, roomHeight, topRoomLength],
                });
                rooms.push({
                    position: [0, roomHeight / 2, dimensions.length / 4],
                    dimensions: [dimensions.width, roomHeight, bottomRoomLength],
                });
            },
            // One large on left, two stacked on right
            () => {
                const leftRoomWidth = dimensions.width / 2;
                const rightRoomWidth = dimensions.width / 2;
                const rightRoomLength = dimensions.length / 2;

                rooms.push({
                    position: [-(dimensions.width / 4), roomHeight / 2, 0],
                    dimensions: [leftRoomWidth, roomHeight, dimensions.length],
                });
                rooms.push({
                    position: [dimensions.width / 4, roomHeight / 2, -(dimensions.length / 4)],
                    dimensions: [rightRoomWidth, roomHeight, rightRoomLength],
                });
                rooms.push({
                    position: [dimensions.width / 4, roomHeight / 2, dimensions.length / 4],
                    dimensions: [rightRoomWidth, roomHeight, rightRoomLength],
                });
            }
        ];

        const randomArrangement = arrangements[Math.floor(Math.random() * arrangements.length)];
        randomArrangement();
    } else if (numRooms === 4) {
        // 2x2 grid
        const roomWidth = dimensions.width / 2;
        const roomLength = dimensions.length / 2;

        for (let i = 0; i < 4; i++) {
            const row = Math.floor(i / 2);
            const col = i % 2;
            const x = (col * roomWidth) - (dimensions.width / 2) + (roomWidth / 2);
            const z = (row * roomLength) - (dimensions.length / 2) + (roomLength / 2);

            rooms.push({
                position: [x, roomHeight / 2, z],
                dimensions: [roomWidth, roomHeight, roomLength],
            });
        }
    } else if (numRooms === 5) {
        // Five rooms - random arrangement
        const arrangements = [
            // 3 on top, 2 below
            () => {
                const topRoomWidth = dimensions.width / 3;
                const topRoomLength = dimensions.length / 2;
                const bottomRoomLength = dimensions.length / 2;

                // Top row - 3 rooms
                for (let i = 0; i < 3; i++) {
                    const x = (i * topRoomWidth) - (dimensions.width / 2) + (topRoomWidth / 2);
                    rooms.push({
                        position: [x, roomHeight / 2, -(dimensions.length / 4)],
                        dimensions: [topRoomWidth, roomHeight, topRoomLength],
                    });
                }

                // Bottom row - 2 rooms
                const bottomRoomWidth = dimensions.width / 2;
                rooms.push({
                    position: [-(dimensions.width / 4), roomHeight / 2, dimensions.length / 4],
                    dimensions: [bottomRoomWidth, roomHeight, bottomRoomLength],
                });
                rooms.push({
                    position: [dimensions.width / 4, roomHeight / 2, dimensions.length / 4],
                    dimensions: [bottomRoomWidth, roomHeight, bottomRoomLength],
                });
            },
            // 2 on left, 3 stacked on right
            () => {
                const leftRoomWidth = dimensions.width / 2;
                const rightRoomWidth = dimensions.width / 2;
                const leftRoomLength = dimensions.length / 2;
                const rightRoomLength = dimensions.length / 3;

                // Left side - 2 rooms
                rooms.push({
                    position: [-(dimensions.width / 4), roomHeight / 2, -(dimensions.length / 4)],
                    dimensions: [leftRoomWidth, roomHeight, leftRoomLength],
                });
                rooms.push({
                    position: [-(dimensions.width / 4), roomHeight / 2, dimensions.length / 4],
                    dimensions: [leftRoomWidth, roomHeight, leftRoomLength],
                });

                // Right side - 3 rooms
                for (let i = 0; i < 3; i++) {
                    const z = (i * rightRoomLength) - (dimensions.length / 2) + (rightRoomLength / 2);
                    rooms.push({
                        position: [dimensions.width / 4, roomHeight / 2, z],
                        dimensions: [rightRoomWidth, roomHeight, rightRoomLength],
                    });
                }
            }
        ];

        const randomArrangement = arrangements[Math.floor(Math.random() * arrangements.length)];
        randomArrangement();
    } else if (numRooms === 6) {
        // 2x3 grid
        const roomWidth = dimensions.width / 2;
        const roomLength = dimensions.length / 3;

        for (let i = 0; i < 6; i++) {
            const row = Math.floor(i / 2);
            const col = i % 2;
            const x = (col * roomWidth) - (dimensions.width / 2) + (roomWidth / 2);
            const z = (row * roomLength) - (dimensions.length / 2) + (roomLength / 2);

            rooms.push({
                position: [x, roomHeight / 2, z],
                dimensions: [roomWidth, roomHeight, roomLength],
            });
        }
    } else if (numRooms === 7) {
        // Seven rooms - random arrangement
        const arrangements = [
            // 3 on top, 4 below
            () => {
                const topRoomWidth = dimensions.width / 3;
                const topRoomLength = dimensions.length / 2;
                const bottomRoomLength = dimensions.length / 2;

                // Top row - 3 rooms
                for (let i = 0; i < 3; i++) {
                    const x = (i * topRoomWidth) - (dimensions.width / 2) + (topRoomWidth / 2);
                    rooms.push({
                        position: [x, roomHeight / 2, -(dimensions.length / 4)],
                        dimensions: [topRoomWidth, roomHeight, topRoomLength],
                    });
                }

                // Bottom row - 4 rooms
                const bottomRoomWidth = dimensions.width / 4;
                for (let i = 0; i < 4; i++) {
                    const x = (i * bottomRoomWidth) - (dimensions.width / 2) + (bottomRoomWidth / 2);
                    rooms.push({
                        position: [x, roomHeight / 2, dimensions.length / 4],
                        dimensions: [bottomRoomWidth, roomHeight, bottomRoomLength],
                    });
                }
            },
            // 4 on top, 3 below
            () => {
                const topRoomWidth = dimensions.width / 4;
                const topRoomLength = dimensions.length / 2;
                const bottomRoomLength = dimensions.length / 2;

                // Top row - 4 rooms
                for (let i = 0; i < 4; i++) {
                    const x = (i * topRoomWidth) - (dimensions.width / 2) + (topRoomWidth / 2);
                    rooms.push({
                        position: [x, roomHeight / 2, -(dimensions.length / 4)],
                        dimensions: [topRoomWidth, roomHeight, topRoomLength],
                    });
                }

                // Bottom row - 3 rooms
                const bottomRoomWidth = dimensions.width / 3;
                for (let i = 0; i < 3; i++) {
                    const x = (i * bottomRoomWidth) - (dimensions.width / 2) + (bottomRoomWidth / 2);
                    rooms.push({
                        position: [x, roomHeight / 2, dimensions.length / 4],
                        dimensions: [bottomRoomWidth, roomHeight, bottomRoomLength],
                    });
                }
            }
        ];

        const randomArrangement = arrangements[Math.floor(Math.random() * arrangements.length)];
        randomArrangement();
    } else if (numRooms === 8) {
        // 2x4 grid
        const roomWidth = dimensions.width / 2;
        const roomLength = dimensions.length / 4;

        for (let i = 0; i < 8; i++) {
            const row = Math.floor(i / 2);
            const col = i % 2;
            const x = (col * roomWidth) - (dimensions.width / 2) + (roomWidth / 2);
            const z = (row * roomLength) - (dimensions.length / 2) + (roomLength / 2);

            rooms.push({
                position: [x, roomHeight / 2, z],
                dimensions: [roomWidth, roomHeight, roomLength],
            });
        }
    } else if (numRooms === 9) {
        // 3x3 grid
        const roomWidth = dimensions.width / 3;
        const roomLength = dimensions.length / 3;

        for (let i = 0; i < 9; i++) {
            const row = Math.floor(i / 3);
            const col = i % 3;
            const x = (col * roomWidth) - (dimensions.width / 2) + (roomWidth / 2);
            const z = (row * roomLength) - (dimensions.length / 2) + (roomLength / 2);

            rooms.push({
                position: [x, roomHeight / 2, z],
                dimensions: [roomWidth, roomHeight, roomLength],
            });
        }
    }

    return rooms;
} 