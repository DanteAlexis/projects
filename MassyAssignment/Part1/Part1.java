/**	@author Dante Alexis
  *
  *	@version 1.0
  *
  * A program that calculates the row wise maximum of numbers organized in a triangle, by adding the parent to the numbers adjacent to it in the next row
  * This implementation sums in reverse order (base of the triangle first)
  */

//Assumption: only positive integers appear in the triangle
//Assumption: the question states "find the total". I assume it doesn't have to be returned but could simply be output
//Assumption: the input file is never empty

import java.io.*;
import java.util.*;

public class Part1
{
	public static void main(String[] args) throws Exception
	{
		ArrayList<ArrayList<Integer>> values = new ArrayList<ArrayList<Integer>>();
		ArrayList<Integer> temp = new ArrayList<Integer>();
		
		File myFile = new File("Triangle.txt");
		Scanner data = new Scanner(myFile);
		int rowCount = 1;
		
		//Store all values in an array
		while(data.hasNextLine())
		{	
			int index = 0;
			while(index < rowCount)
			{
				temp.add(data.nextInt());
				index++;
			}
			values.add(temp);
			temp = new ArrayList<Integer>();
			rowCount++;
		}

		//Now, collapse the triangle in reverse by comparing numbers to their adjacent values and adding the max of this comparison to the parent row. Repeat
		for(int i = values.size()-2; i >= 0; i--)
		{
			for(int j = 0; j < values.get(i+1).size()-1; j++)
			{
				int max = Math.max(values.get(i+1).get(j), values.get(i+1).get(j+1));
				values.get(i).set(j, max+values.get(i).get(j));
			}
		}
		
		System.out.println(values.get(0));
		data.close();
	}
}
