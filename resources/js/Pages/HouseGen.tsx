import { Canvas } from '@react-three/fiber';
import { OrbitControls } from '@react-three/drei';
import { Suspense, useState, useMemo } from 'react';
import { calculateRoomLayout, type Room, type HouseDimensions } from '../utils/roomLayout';
import * as THREE from 'three';

const Room = ({ position, dimensions, color, outerWallColor }: {
    position: [number, number, number];
    dimensions: [number, number, number];
    color: string;
    outerWallColor?: string;
}) => {
    const wallThickness = 0.2; // 20cm wall thickness
    const [width, height, length] = dimensions;

    // Create a hollow box using CSG operations
    const createHollowBox = () => {
        const outerGeometry = new THREE.BoxGeometry(width, height, length);
        const innerGeometry = new THREE.BoxGeometry(
            width - (2 * wallThickness),
            height - (2 * wallThickness),
            length - (2 * wallThickness)
        );

        // Create a single geometry by combining outer and inner
        const geometry = new THREE.BufferGeometry();
        const outerPositions = outerGeometry.attributes.position.array;
        const innerPositions = innerGeometry.attributes.position.array;
        const outerIndices = outerGeometry.index?.array || [];
        const innerIndices = innerGeometry.index?.array || [];

        // Combine vertices and indices
        const positions = new Float32Array(outerPositions.length + innerPositions.length);
        const indices = new Uint32Array(outerIndices.length + innerIndices.length);

        // Copy outer geometry
        positions.set(outerPositions, 0);
        indices.set(outerIndices, 0);

        // Copy inner geometry with offset
        positions.set(innerPositions, outerPositions.length);
        for (let i = 0; i < innerIndices.length; i++) {
            indices[outerIndices.length + i] = innerIndices[i] + outerPositions.length / 3;
        }

        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        geometry.setIndex(new THREE.BufferAttribute(indices, 1));
        geometry.computeVertexNormals();

        // Create a group to hold both the room and the edge lines
        const group = new THREE.Group();

        // Create the main room mesh
        const mesh = new THREE.Mesh(
            geometry,
            new THREE.MeshStandardMaterial({
                color: outerWallColor || color,
                side: THREE.DoubleSide
            })
        );
        group.add(mesh);

        // Create edge lines
        const edges = new THREE.EdgesGeometry(outerGeometry);
        const lineMaterial = new THREE.LineBasicMaterial({ color: 'black', linewidth: 2 });
        const wireframe = new THREE.LineSegments(edges, lineMaterial);
        group.add(wireframe);

        // Create inner edge lines
        const innerEdges = new THREE.EdgesGeometry(innerGeometry);
        const innerWireframe = new THREE.LineSegments(innerEdges, lineMaterial);
        group.add(innerWireframe);

        return group;
    };

    return (
        <primitive object={createHollowBox()} position={position} />
    );
};

const HouseGen = () => {
    const [dimensions, setDimensions] = useState<HouseDimensions>({
        length: 10,
        width: 10,
        height: 3
    });

    const [numRooms, setNumRooms] = useState(4);
    const [wallColor, setWallColor] = useState('#D2D8E4');

    const defaultDimensions: HouseDimensions = {
        length: 10,
        width: 10,
        height: 3
    };

    const handleDimensionChange = (dimension: 'length' | 'width' | 'height', value: number) => {
        setDimensions(prev => ({
            ...prev,
            [dimension]: value
        }));
    };

    const handleReset = () => {
        setDimensions(defaultDimensions);
        setNumRooms(4);
        setWallColor('#D2D8E4');
    };

    // Calculate room layout using the utility function
    const roomLayout = useMemo(() => {
        return calculateRoomLayout(numRooms, dimensions);
    }, [numRooms, dimensions]);

    return (
        <div className="w-full h-screen relative">
            {/* Control Panel */}
            <div className="absolute top-4 left-4 bg-white/90 backdrop-blur-sm p-4 rounded-lg shadow-lg z-10 min-w-64">
                <h2 className="text-lg font-semibold mb-4 text-gray-800">House Layout (Meters)</h2>

                <div className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                            Length: {dimensions.length}m
                        </label>
                        <input
                            type="range"
                            min="5"
                            max="20"
                            step="0.5"
                            value={dimensions.length}
                            onChange={(e) => handleDimensionChange('length', parseFloat(e.target.value))}
                            className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                            Width: {dimensions.width}m
                        </label>
                        <input
                            type="range"
                            min="4"
                            max="15"
                            step="0.5"
                            value={dimensions.width}
                            onChange={(e) => handleDimensionChange('width', parseFloat(e.target.value))}
                            className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                            Height: {dimensions.height}m
                        </label>
                        <input
                            type="range"
                            min="2"
                            max="6"
                            step="0.2"
                            value={dimensions.height}
                            onChange={(e) => handleDimensionChange('height', parseFloat(e.target.value))}
                            className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                            Number of Rooms: {numRooms}
                        </label>
                        <input
                            type="range"
                            min="1"
                            max="9"
                            step="1"
                            value={numRooms}
                            onChange={(e) => setNumRooms(parseInt(e.target.value))}
                            className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                            Wall Color
                        </label>
                        <input
                            type="color"
                            value={wallColor}
                            onChange={(e) => setWallColor(e.target.value)}
                            className="w-full h-10 rounded-lg cursor-pointer"
                        />
                    </div>

                    <div className="pt-2">
                        <button
                            onClick={handleReset}
                            className="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
                        >
                            Reset to Default
                        </button>
                    </div>
                </div>
            </div>

            <Canvas camera={{ position: [15, 15, 15] }}>
                <Suspense fallback={null}>
                    {/* Lighting */}
                    <ambientLight intensity={0.5} />
                    <directionalLight position={[10, 10, 5]} intensity={1} />

                    {/* Rooms */}
                    {roomLayout.map((room, index) => (
                        <Room
                            key={index}
                            position={room.position}
                            dimensions={room.dimensions}
                            color={wallColor}
                        />
                    ))}

                    {/* Camera Controls */}
                    <OrbitControls />
                </Suspense>
            </Canvas>
        </div>
    );
};

export default HouseGen;